<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use AppBundle\Entity\Usuario;
//use AppBundle\Form\UsuarioType;

class PruebaUsuarioController extends Controller
{
    /**
     * @Route("/usuariopruebas", name="Pruebas")
     */
    
    public function indexAction()
    {
        
        $em =  $this->getDoctrine()->getEntityManager();
        $usuario_repo = $em->getRepository("AppBundle:Usuario");
        $usuarios = $usuario_repo->findAll(); 

        foreach ($usuarios as $usuario) 
        {
            echo $usuario->getUser()."<br/>";
            echo $usuario->getPassword()."<br/>";
            echo $usuario->getRole()."<br/>";
            # Datos de Persona de un Usuario
            echo $usuario->getPersona()->getNombre()." ";
            echo $usuario->getPersona()->getApellido()."<br/>";
            # Prueba Extraer Cursos De Un Usuario
            $cursos = $usuario->getPersona()->getPersCurs();
            foreach ($cursos as $curso) 
            {
                echo $curso->getCursos()->getNombreCurso(),"<br/>";
            }
               
        }

        die();
        //return $this->render('AppBundle:Default:index.html.twig');
    }
}
