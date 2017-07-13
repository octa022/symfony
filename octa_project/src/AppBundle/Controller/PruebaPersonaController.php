<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use AppBundle\Entity\Usuario;
//use AppBundle\Form\UsuarioType;

class PruebaPersonaController extends Controller
{
    /**
     * @Route("/personapruebas", name="PruebasPersonas")
     */
    
    public function indexAction()
    {
        $em=$this->getDoctrine()->getEntityManager();
        $persona_repo = $em->getRepository("AppBundle:Persona");
        $personas = $persona_repo->findAll(); /*pruebas61*/


        foreach ($personas as $persona) 
        {
            # Imprimir Personas
            echo $persona->getNombre()."<br/>";
            echo $persona->getApellido()."<br/>";
            
            # Usuarios
            $usuarios = $persona->getUsuario();
            foreach ($usuarios as $usuario) 
            {
                echo $usuario->getUser(). ", ";
            }
            echo "<hr/>";
            
            #telefonos de personas
            $telefonos = $persona->getTelefono();
            foreach ($telefonos as $telefono) 
            {
                echo $telefono->getNumero(). ", ";
            }
            echo "<hr/>";
            #cursos de personas
            $cursos = $persona->getPersCurs();
            foreach ($cursos as $curso) 
            {
                echo $curso->getCursos()->getNombreCurso(). ", ";
                echo $curso->getCursos()->getTutor(). ", ";
                echo $curso->getCursos()->getDescripcion(). ", ";
            }
            echo "<hr/>";

        }

        die();

        #//return $this->render('AppBundle:Default:index.html.twig');
      
    }
}
