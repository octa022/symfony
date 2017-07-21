<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Cursos;
use AppBundle\Entity\PersCurs;
use AppBundle\Form\CursosType;

class CursosController extends Controller
{
    private $session;

    public function __construct(){
        $this->session=new Session();
    }

    public function indexAction(){

        $em=$this->getDoctrine()->getEntityManager();
        $curso_repo = $em->getRepository("AppBundle:Cursos");
        $cursos = $curso_repo->findAll();


        $persona_repo = $em->getRepository("AppBundle:Persona");
        $personas = $persona_repo->findAll();

        return $this->render('AppBundle:Cursos:index.html.twig', array(
            "cursos" => $cursos,
            "personas" => $personas
        ));

    }
    
    public function addAction(Request $request)
    {
        /*Formulario*/
        $curso = new Cursos();
        $form = $this->createForm(CursosType::class,$curso);

        $form->handleRequest($request); /*Recoger del Formulario*/

        if($form->isSubmitted()) /*Validar*/
        {
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getEntityManager();
               
                $curso = new Cursos();
                $curso->setNombreCurso($form->get("nombreCurso")->getData());
                $curso->setTutor($form->get("tutor")->getData());
                $curso->setDescripcion($form->get("descripcion")->getData());

                #Id de Persona Actual
                $persona_repo = $em->getRepository("AppBundle:Persona");
                $persona = $persona_repo->findOneByUsuario($this->getUser()->getId());
                
                $perscurs= new PersCurs();
                $perscurs->setPersona($persona);
                $perscurs->setCursos($curso);

                $em->persist($curso);
                $em->persist($perscurs);
                $flush = $em->flush();
                if($flush==null){
                        $status = "Todo Excelente...!!!"; 
                }
                else
                {
                    $status = "Error, Intenta Nuevamente...!!!"; 
                }

                //return $this->redirectToRoute("Blog_index_cursos"); /*Redireccion*/ 
            }
            else
            {
                $status = "Rellenar Correctamente...!!!"; 
            }

            /*SMS Inf*/
            $this->session->getFlashBag()->add("status",$status); 
            return $this->redirectToRoute("Blog_index_cursos"); /*Redireccion*/ 
        }

        return $this->render('AppBundle:Cursos:add.html.twig', array(
            "form" => $form->createView() 
        ));
    }

    public function deleteAction($id)
    { //73
        $em=$this->getDoctrine()->getEntityManager();
        $curso_repo = $em->getRepository("AppBundle:Cursos");
        $curso=$curso_repo->find($id);
        # Borrar Curso
        var_dump(count($curso->getPersCurs()));
        if (count($curso->getPersCurs())==0)
        {
            $em->remove($curso);
            $em->flush();
        }
        
        
        return $this->redirectToRoute("Blog_index_cursos");

    }    
        
}