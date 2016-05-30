<?php

namespace MagicWordBundle\Form\Type\RoundType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use MagicWordBundle\Form\Type\ObjectiveType\FindWordType;

class ConquerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('objectives', CollectionType::class, array(
            'entry_type' => FindWordType::class,
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'mapped' => true,
            'by_reference' => false,
        ));
    }

    public function getName()
    {
        return 'conquer';
    }
}
