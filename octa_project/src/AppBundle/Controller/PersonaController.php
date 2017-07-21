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

        //$perscurs = $curso_repo->findBy(array("persona"=>$persona));
        //$perscurs = $perscurs_repo->findOneByCursos(1);
        //echo $perscurs->getId();
        //echo $cursos->getNombreCurso();
        //die();



        //$persona = $persona_repo->findOneByUsuario($user);

        #$curso_repo = $em->getRepository("AppBundle:Cursos");
        #$cursos = $curso_repo->findOneById(2);
        #//$cursos = $curso_repo->findBy(array("NombreCurso"=>PHP));
        ##$personas = $persona_repo->findOneByUsuario(2);
        ##echo $user;
        #echo $cursos->getNombreCurso();

        //echo $telefono[2]->getNumero();

        //echo $cursos;
        //die();


        return $this->render('AppBundle:Persona:index.html.twig', array(
            //"personas" => $personas,
            "telefonos" => $telefonos,
            "persona" => $persona,
            //"telefonoss" => $telefono
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
                    /*cifrar contraseñas*/

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

                    #############3

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
        
        return $this->render('AppBundle:Persona:add.html.twig', array(
            "form" => $form->createView() 
        ));
    }

}