<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CursosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreCurso',TextType::class, array("label"=>"Curso","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('tutor',TextType::class, array("label"=>"Tutor","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('descripcion',TextareaType::class, array("label"=>"Descripcion","required"=>"required", "attr" =>array("class" => "form_name form-control")))
            ->add('Guardar',SubmitType::class, array("attr" =>array("class" => "form_submit btn btn-success")))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cursos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cursos';
    }


}
