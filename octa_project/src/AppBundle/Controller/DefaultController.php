<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use AppBundle\Entity\Usuario;
//use AppBundle\Form\UsuarioType;

class DefaultController extends Controller
{
       
    public function indexAction()
    {
       
        return $this->render('AppBundle:Default:index.html.twig');
      
    }
    public function ayudaAction()
    {
       
        return $this->render('AppBundle:Default:ayuda.html.twig');
      
    }
}
