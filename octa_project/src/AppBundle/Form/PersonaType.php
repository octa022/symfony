<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class PersonaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class, array("label"=>"Nombre","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('apellido',TextType::class, array("label"=>"Apellido","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ##
            //->add('telefono',TextType::class, array("label"=>"Telefono","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ##
            //->add('usuario',TextType::class, array("label"=>"usuario","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            //->add('password',TextType::class, array("label"=>"contraseña","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ###
            ->add('Guardar',SubmitType::class, array("attr" =>array("class" => "form_submit btn btn-success")))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Persona'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_persona';
    }


}
