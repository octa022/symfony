<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use AppBundle\Entity\Persona;
use AppBundle\Form\PersonaType;

class UsuarioController extends Controller
{
    /*SMS Emergentes*/
    private $session;

    public function __construct(){
        $this->session = new Session(); 
    }
                
    public function loginAction(Request $request)
    {
        #Login
        $authenticationUtils = $this->get("security.authentication_utils");
    	$error = $authenticationUtils->getLastAuthenticationError();
    	$lastUsername = $authenticationUtils->getLastUsername();
        #####
        #Registro
        $persona = new Persona();
        $usuario = new Usuario();
        $formP = $this->createForm(PersonaType::class,$persona);
        $formU = $this->createForm(UsuarioType::class,$usuario);

        $formP->handleRequest($request);
        $formU->handleRequest($request);
        
        if (($formP->isValid()) or ($formU->isValid()))    
        {
            $usuario = new Usuario();
            $persona = new Persona();
            $persona->setNombre($formP->get("nombre")->getData());
            $persona->setApellido($formP->get("apellido")->getData());


            $usuario->setUser($formU->get("user")->getData());
            $usuario->setPassword($formU->get("password")->getData());
            $usuario->setRole("ROLE_USER");
            $usuario->setPersona();

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($usuario);
            //$em->persist($persona);
            $flush = $em->flush();
            if($flush==null)
            {
                //$em->persist($persona);
                //$flush = $em->flush();
                //$em->persist($usuario);
                //$flush = $em->flush();
                $status = "Te has registrado!!!";
            }
            else
            {
                $status = "No te registraste De Forma Correcta, Intentalo Nuevamente.!";
            }
        }
        else
        {
            $status = "No te registraste De Forma Correcta";
        }

        $this->session->getFlashBag()->add("status",$status);   
                
        //devolver la vista
        return $this->render('AppBundle:Usuario:login.html.twig', array(
            "error" => $error,
            "last_username" => $lastUsername,
            "formP" => $formP->createView(),
            "formU" => $formU->createView(),

            
        ));   
    }
}