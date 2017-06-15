<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use MagicWordBundle\Form\Type\GridPatternStringType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class GridPatternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'name',
            'required' => false,
        ));

        $builder->add('description', TextareaType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'description',
            'required' => false,
        ));

        $builder->add('strings', CollectionType::class, array(
            'entry_type' => GridPatternStringType::class,
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'mapped' => true,
            'by_reference' => false,
        ));
    }

    public function getName()
    {
        return 'gridPattern';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MagicWordBundle\Entity\GridPattern',
        ));
    }
}
