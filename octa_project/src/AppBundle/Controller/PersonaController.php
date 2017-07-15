<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Persona;
use AppBundle\Form\PersonaType;

class PersonaController extends Controller
{
    private $session;

    public function __construct(){
        $this->session=new Session();
    }
    
    public function addAction(Request $request)
    {
        /*Formulario*/
        $persona = new Persona();
        $form = $this->createForm(PersonaType::class,$persona);

        $form->handleRequest($request); /*Recoger del Formulario*/

        if($form->isSubmitted()) /*Validar*/
        {
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getEntityManager();
                $persona_repo =$em->getRepository("AppBundle:Persona");
                               
                $persona = new Persona();
                $persona->setNombre($form->get("nombre")->getData());
                $persona->setApellido($form->get("apellido")->getData());
                                
                $em->persist($persona);
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
                $status = "Rellenar Correctamente...!!!"; 
            }

            /*SMS Inf*/
            $this->session->getFlashBag()->add("status",$status);  
        }

        return $this->render('AppBundle:Persona:add.html.twig', array(
            "form" => $form->createView() 
        ));
    }
        



}