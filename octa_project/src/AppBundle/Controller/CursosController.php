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

        $perscurs_repo = $em->getRepository("AppBundle:PersCurs");
        $perscurs = $perscurs_repo->findAll();

        return $this->render('AppBundle:Cursos:index.html.twig', array(
            "cursos" => $cursos,
            "personas" => $personas,
            "perscurs" =>  $perscurs
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
    { 
        $em=$this->getDoctrine()->getEntityManager();
        $curso_repo = $em->getRepository("AppBundle:Cursos");
        $curso=$curso_repo->find($id);
        # Borrar Relacion de Curso
        $persona_repo = $em->getRepository("AppBundle:Persona");
        $persona = $persona_repo->findOneByUsuario($this->getUser()->getId());

        $perscurs_repo = $em->getRepository("AppBundle:PersCurs");
        $pc_cursos = $perscurs_repo->findBy(array("cursos"=>$curso)); # ID de relacion de persona con P_C
        $pc_personas = $perscurs_repo->findBy(array("persona"=>$persona)); # ID de relacion de persona con P_C


        foreach ($pc_cursos as $pc_c){
            foreach ($pc_personas as $pc_p) {
                if ($pc_c == $pc_p){

                    $em->remove($pc_c);
                    $em->flush();
                     
                }
                else{ echo "no"; }
             }
        }

        
        return $this->redirectToRoute("Blog_index_cursos");

    }

    public function editAction(Request $request, $id)
    { 
        $em=$this->getDoctrine()->getEntityManager();
        $curso_repo = $em->getRepository("AppBundle:Cursos");
        $curso=$curso_repo->find($id);
     
        $form = $this->createForm(CursosType::class,$curso);
        $form->handleRequest($request);
        
        if($form->isSubmitted()) 
        {
            if ($form->isValid())
            {
                $curso->setNombreCurso($form->get("nombreCurso")->getData());
                $curso->setTutor($form->get("tutor")->getData());
                $curso->setDescripcion($form->get("descripcion")->getData());

                $em->persist($curso);

                $flush = $em->flush();
                if($flush==null){
                        $status = "Todo Excelente...!!!"; 
                }
                else
                {
                    $status = "Error, Intenta Nuevamente...!!!"; 
                }
            }
            else
            {
                $status = "No se ha podido Editar Correctamente...!!!"; 
            }

            /*SMS Inf*/
            $this->session->getFlashBag()->add("status",$status); 
            return $this->redirectToRoute("Blog_index_cursos"); 
        }

        return $this->render('AppBundle:Cursos:edit.html.twig', array(
            "form" => $form->createView() 
        )); 
    }

    
    public function newAction(Request $request, $id)
    { 
        $em=$this->getDoctrine()->getEntityManager();
        $curso_repo = $em->getRepository("AppBundle:Cursos");
        $curso=$curso_repo->find($id);

        $persona_repo = $em->getRepository("AppBundle:Persona");
        $persona = $persona_repo->findOneByUsuario($this->getUser()->getId());

        # Comprobar si ya inscribio el curso
        $perscurs_repo = $em->getRepository("AppBundle:PersCurs");
        $pc_cursos = $perscurs_repo->findBy(array("cursos"=>$curso)); # ID de relacion de persona con PC
        $pc_personas = $perscurs_repo->findBy(array("persona"=>$persona)); # ID de relacion de persona con PC

        $inscrito = 0;
        foreach ($pc_cursos as $pc_c){
            foreach ($pc_personas as $pc_p) {
 
                if ($pc_c == $pc_p){
 
                    echo $pc_c->getId(); echo "/";
                    echo $pc_p->getId(); echo "/";
                    $inscrito =  $inscrito+1;
     
                }elseif ((count($pc_cursos) !== 0)){ echo " no "; }
             }
        }

     
        if((count($pc_cursos) == 0))        
        {
            $perscurs= new PersCurs();          #
            $perscurs->setPersona($persona);    #
            $perscurs->setCursos($curso);       #
            $em->persist($perscurs);        #
            $em->flush();                   #
            $status = "Inscribiste el Curso";               #

        }
        elseif((count($pc_cursos) >= 1)  and ($inscrito == 0))   {
           $perscurs= new PersCurs();          #
            $perscurs->setPersona($persona);    #
            $perscurs->setCursos($curso);       #
            $em->persist($perscurs);        #
            $em->flush();                   #
            $status = "Inscribiste el Curso";               #
        }
        
        else
            {
                $status = "Ya Existe el Curso";
            }
        
        $this->session->getFlashBag()->add("status",$status);
        return $this->redirectToRoute("Blog_index_cursos");
        
    }     
        
}