<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;

class UsuarioController extends Controller
{
    /*SMS Emergentes*/
    private $session;

    public function __construct(){
        $this->session = new Session(); 
    }
                
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get("security.authentication_utils");
    	$error = $authenticationUtils->getLastAuthenticationError();
    	$lastUsername = $authenticationUtils->getLastUsername();

        /*Formulario*/
        $user = new Usuario();
        $form = $this->createForm(UsuarioType::class,$user);

        $form->handleRequest($request);
        /*Comprobar si el formulario se envio*/
        if($form->isSubmitted()) 
        {
            if ($form->isValid())   
            {
                #Chequeo para saber si un usuario esta repetido
                $em=$this->getDoctrine()->getEntityManager();
                $user_repo=$em->getRepository("AppBundle:Usuario");    
                $user = $user_repo->findOneBy(array("user"=>$form->get("user")->getData()));
                #Si el usuario no existe, crear usuario
                if(count($user)==0) 
                {
                    $user = new Usuario();
                    $user->setUser($form->get("user")->getData());

                    /*cifrar contraseñas*/
                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($form->get("password")->getData(),$user->getSalt());
                    /*cifrar contraseñas*/

                    $user->setPassword($password);
                    $user->setRole("ROLE_USER");

                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($user);
                    $flush = $em->flush();
                    if($flush==null)
                    {
                        $status = "Te has registrado!!!";
                    }
                    else
                    {
                        $status = "No te registraste De Forma Correcta";
                    }
                }
                else
                {
                    $status = "Ya Existe el Usuario";
                }
            }
            else
            {
                $status = "No te registraste De Forma Correcta";
            }

            $this->session->getFlashBag()->add("status",$status);   
        }
    

       
        
        //devolver la vista
        return $this->render('AppBundle:Usuario:login.html.twig', array(
            "error" => $error,
            "last_username" => $lastUsername,
            "form" => $form->createView()

            
        ));   
    }
}