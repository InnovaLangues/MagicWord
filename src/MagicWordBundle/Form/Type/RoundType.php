<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use MagicWordBundle\Form\Type\ObjectiveType\FindWordType;
use MagicWordBundle\Form\Type\ObjectiveType\ComboType;
use MagicWordBundle\Form\Type\ObjectiveType\ConstraintType;

class RoundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('findWords', CollectionType::class, array(
            'entry_type' => FindWordType::class,
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'mapped' => true,
            'by_reference' => false,
        ));

        $builder->add('constraints', CollectionType::class, array(
            'entry_type' => ConstraintType::class,
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'mapped' => true,
            'by_reference' => false,
        ));

        $builder->add('combos', CollectionType::class, array(
            'entry_type' => ComboType::class,
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
