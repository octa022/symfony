<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PersCurs;
//use AppBundle\Form\UsuarioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\PersCursType;

class PersCursController extends Controller
{
       
    public function addAction(Request $request)
    {
        /*Formulario*/
        $perscurs = new PersCurs();

        $em=$this->getDoctrine()->getEntityManager();
		$form = $this->createForm(PersCursType::class,$perscurs);
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

                //$em->persist($curso);
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

        return $this->render('AppBundle:PersCurs:add.html.twig', array(
            "form" => $form->createView() 
        )); 
    }
}
