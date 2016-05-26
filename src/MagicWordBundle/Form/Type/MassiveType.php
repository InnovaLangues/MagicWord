<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MassiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'attr' => array('class' => 'form-control'),
        ));

        $builder->add('description', TextType::class, array(
            'attr' => array('class' => 'form-control'),
        ));

        $builder->add('language', EntityType::class, array(
           'class' => 'MagicWordBundle:Language',
           'choice_label' => 'name',
           'attr' => array('class' => 'form-control'),
        ));

        $builder->add('public', CheckboxType::class, array(
            'label' => 'Publique ?',
            'required' => false,
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'generic.validate',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'massive';
    }
}
