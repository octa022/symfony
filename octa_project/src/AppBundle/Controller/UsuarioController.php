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
//use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Telefono;

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

        return $this->render('AppBundle:Usuario:login.html.twig', array(
            "error" => $error,
            "last_username" => $lastUsername
            
        ));   
    }

    public function registroAction(Request $request)
    {
        $user = new Usuario();
        $telefono = new Telefono();
        $persona = new Persona();

        $form = $this->createFormBuilder()
            ->add('nombre',TextType::class, array("label"=>"Nombre","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('apellido',TextType::class, array("label"=>"Apellido","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('user',TextType::class, array("label"=>"Usuario","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('password',PasswordType::class, array("label"=>"Contraseña","required"=>"required", "attr" =>array("class" => "form_password form-control")))
            ->add('numero',TextType::class, array("label"=>"Telefono","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('Guardar',SubmitType::class, array("attr" =>array("class" => "form_submit btn btn-success")))
            ->getForm()
        ;

        $form->handleRequest($request);
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

                    //$persona_repo =$em->getRepository("AppBundle:Persona");

                    $persona = new Persona();
                    $persona->setNombre($form->get("nombre")->getData());
                    $persona->setApellido($form->get("apellido")->getData());
                    $persona->setUsuario($user);
                   
                    $telefono = new Telefono();
                    $telefono->setNumero($form->get("numero")->getData());
                    $telefono->setPersona($persona);

                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($user);
                    $em->persist($persona);
                    $em->persist($telefono);
                    //$flush = $em->flush();
                    $flush = $em->flush();
                    if($flush==null)
                    {
                        $status = "Te has registrado!!!";
                    }
                    else
                    {
                        $status = "No te registraste De Forma Correcta";
                    }
                   
                    return $this->redirectToRoute("Blog_index_persona"); /*Redireccion*/ 
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
         
        
        return $this->render('AppBundle:Usuario:registro.html.twig', array(
            "form" => $form->createView()
        ));   
    }


}