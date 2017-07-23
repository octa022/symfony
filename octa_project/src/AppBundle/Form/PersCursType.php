<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersCursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //->add('cursos',ChoiceType::class, array( 
        //    'choices' => array("AppBundle:Cursos"),
        //    "expanded"=>true, "multiple"=>true))
        ->add('cursos',EntityType::class, array(
            'class' => 'AppBundle\Entity\Cursos',
            'choice_label' => 'nombreCurso',
            'expanded' => true,
            'multiple' => true))
        ->add('persona')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PersCurs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_perscurs';
    }


}
