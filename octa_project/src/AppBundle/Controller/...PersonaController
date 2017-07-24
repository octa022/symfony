<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Telefono;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Cursos;
use AppBundle\Entity\PersCurs;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\PersonaType;

class PersonaController extends Controller
{
    private $session;

    public function __construct(){
        $this->session=new Session();
    }

    public function indexAction(){

        $em=$this->getDoctrine()->getEntityManager();
        # Extraer Persona Actual
        $user = $this->getUser()->getId(); 
        $persona_repo = $em->getRepository("AppBundle:Persona");
        $persona = $persona_repo->findOneByUsuario($user);
        # Telefonos de Persona
        $telf_repo = $em->getRepository("AppBundle:Telefono");
        $telefonos = $telf_repo->findBy(array("persona"=>$persona));
        # Cursos de Persona
        $perscurs_repo = $em->getRepository("AppBundle:PersCurs");
        $perscurs = $perscurs_repo->findBy(array("persona"=>$persona));
        # Cursos
        $cursos_repo = $em->getRepository("AppBundle:Cursos");
        $cursos = $cursos_repo->findAll();

        return $this->render('AppBundle:Persona:index.html.twig', array(
            "telefonos" => $telefonos,
            "persona" => $persona,
            "cursos" => $cursos,
            "perscurs" => $perscurs,
        ));

    }
    
    public function addAction(Request $request)
    {
        $user = new Usuario();
        $persona = new Persona();
        $telefono = new Telefono();
        $cursos = new Cursos();
        
        $form = $this->createFormBuilder()
            ->add('nombre',TextType::class, array("label"=>"Nombre","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('apellido',TextType::class, array("label"=>"Apellido","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('user',TextType::class, array("label"=>"Usuario","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('password',PasswordType::class, array("label"=>"Contraseña","required"=>"required", "attr" =>array("class" => "form_password form-control")))
            ->add('numero',TextType::class, array("label"=>"Telefono","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('nombreCurso',TextType::class, array("label"=>"Curso","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('tutor',TextType::class, array("label"=>"Tutor","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('descripcion',TextareaType::class, array("label"=>"Descripcion","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('Guardar',SubmitType::class, array("attr" =>array("class" => "form_submit btn btn-success")))
            ->getForm()
        ;

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

                    $user->setPassword($password);
                    $user->setRole("ROLE_USER");

                    #Persona
                    $persona = new Persona();
                    $persona->setUsuario($user);
                    $persona->setNombre($form->get("nombre")->getData());
                    $persona->setApellido($form->get("apellido")->getData());
                    
                    # Telefono
                    $telefono = new Telefono();
                    $telefono->setPersona($persona);
                    $telefono->setNumero($form->get("numero")->getData());
                    
                    # Cursos
                                       
                    $cursos = new Cursos();
                    $cursos->setNombreCurso($form->get("nombreCurso")->getData());
                    $cursos->setTutor($form->get("tutor")->getData());
                    $cursos->setDescripcion($form->get("descripcion")->getData());

                    $perscurs= new PersCurs();
                    $perscurs->setPersona($persona);
                    $perscurs->setCursos($cursos);

                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($user);
                    $em->persist($persona);
                    $em->persist($telefono);
                    $em->persist($cursos);
                    $em->persist($perscurs);

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
        
        return $this->render('AppBundle:Persona:add.html.twig', array(
            "form" => $form->createView() 
        ));
    }

    # Borrar
    public function deleteAction($id)
    { 
        $em=$this->getDoctrine()->getEntityManager();        
        $persona_repo = $em->getRepository("AppBundle:Persona");
        $perscurs_repo = $em->getRepository("AppBundle:PersCurs");
        

        $persona = $persona_repo->find($id);
        # Borrar Telefono de Persona
        //$usuario=$usuario_repo->findBy(array("persona"=>$persona));
        $perscurs=$perscurs_repo->findBy(array("persona"=>$persona));

        foreach ($perscurs as $pC)
        {
            $em->remove($pC);
            //$em->flush();
        }

        $ptelefonos_repo = $em->getRepository("AppBundle:Telefono");
        $telefonos=$ptelefonos_repo->findBy(array("persona"=>$persona));
        foreach ($telefonos as $telefono)
        {
            $em->remove($telefono);
            //$em->flush();
        }


        #$usuario_repo = $em->getRepository("AppBundle:Usuario");
        #$usuario=$usuario_repo->findBy(array("persona"=>$persona));
        
        $user = $this->getUser();
        $em->remove($user);
        //$em->flush(); 
        //foreach ($usuario as $user)
        //{
        //    $em->remove($user);
        //    $em->flush();
        //}

        //$em->remove($persona);
        $em->flush();
                
        //return $this->redirectToRoute("app_homepage");
        return $this->redirectToRoute("logout");

    }


    public function editAction(Request $request, $id)
    { 
        $em=$this->getDoctrine()->getEntityManager();
        
        $persona_repo = $em->getRepository("AppBundle:Persona");
        $persona = $persona_repo->find($id);
        
        $form = $this->createForm(PersonaType::class,$persona);

        $form->handleRequest($request);

        if($form->isSubmitted()) 
        {
            if ($form->isValid())
            {
                $persona->setNombre($form->get("nombre")->getData());
                $persona->setApellido($form->get("apellido")->getData());
                               
                $em->persist($persona);
                $flush = $em->flush();
                if($flush==null){
                        $status = "Edicion Excelente...!!!"; 
                }
                else
                {
                    $status = "Error al editar, Intenta Nuevamente...!!!"; 
                }
            }
            else
            {
                $status = "No se ha podido Editar Correctamente...!!!"; 
            }

            $this->session->getFlashBag()->add("status",$status); 
            return $this->redirectToRoute("Blog_index_persona");
        }

        return $this->render('AppBundle:Persona:edit.html.twig', array(
            "form" => $form->createView() 
        )); 

    }

}