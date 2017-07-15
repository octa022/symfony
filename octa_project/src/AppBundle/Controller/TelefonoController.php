<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Telefono;
use AppBundle\Form\TelefonoType;

class TelefonoController extends Controller
{
    private $session;

    public function __construct(){
        $this->session=new Session();
    }

    public function indexAction(){

        $em=$this->getDoctrine()->getEntityManager();
        $telf_repo = $em->getRepository("AppBundle:Telefono");
        $telefonos = $telf_repo->findAll(); /*Regresa todos los telefonos*/

        return $this->render('AppBundle:Telefono:index.html.twig', array(
            "telefonos" => $telefonos
        ));

    }
    
    public function addAction(Request $request)
    {
        /*Formulario*/
        $telefono = new Telefono();
        $form = $this->createForm(TelefonoType::class,$telefono);

        $form->handleRequest($request); /*Recoger del Formulario*/

        if($form->isSubmitted()) /*Validar*/
        {
            if ($form->isValid())
            {
                $em=$this->getDoctrine()->getEntityManager();
               
                $telefono = new Telefono();
                $telefono->setNumero($form->get("numero")->getData());
                
                $em->persist($telefono);
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
            return $this->redirectToRoute("Blog_index_telefonos"); /*Redireccion*/ 
        }

        return $this->render('AppBundle:Telefono:add.html.twig', array(
            "form" => $form->createView() 
        )); 
    }

    public function deleteAction($id)
    { //73
        $em=$this->getDoctrine()->getEntityManager();
        $telf_repo = $em->getRepository("AppBundle:Telefono");
        $telefono=$telf_repo->find($id);
        # Borrar Telefono de Persona
         
        if (count($telefono->getPersona())==0)
        {
            $em->remove($telefono);
            $em->flush();
        }
                
        return $this->redirectToRoute("Blog_index_telefonos");

    }

    public function editAction(Request $request, $id)
    { //74
        $em=$this->getDoctrine()->getEntityManager();
        $telf_repo = $em->getRepository("AppBundle:Telefono");
        $telefono=$telf_repo->find($id);

        
        $form = $this->createForm(TelefonoType::class,$telefono);

        $form->handleRequest($request);

        if($form->isSubmitted()) /*Validar*/
        {
            if ($form->isValid())
            {
               
                $telefono->setNumero($form->get("numero")->getData());
                
                $em->persist($telefono);
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

            /*SMS Inf*/
            $this->session->getFlashBag()->add("status",$status); 
            return $this->redirectToRoute("Blog_index_telefonos"); /*Redireccion*/ 
        }

        return $this->render('AppBundle:Telefono:edit.html.twig', array(
            "form" => $form->createView() 
        )); 




    }


        



}