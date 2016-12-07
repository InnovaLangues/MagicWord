<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MassiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'name',
            'translation_domain' => 'messages',
        ));

        $builder->add('description', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'description',
            'translation_domain' => 'messages',
            'required' => false,
        ));

        $builder->add('accessType', EntityType::class, array(
           'class' => 'MagicWordBundle:AccessType',
           'choice_label' => 'name',
           'label' => 'access_type',
           'translation_domain' => 'messages',
           'choice_translation_domain' => 'messages',
           'attr' => array('class' => 'form-control'),
        ));

        $builder->add('language', EntityType::class, array(
           'class' => 'MagicWordBundle:Language',
           'choice_label' => 'name',
           'label' => 'language',
           'translation_domain' => 'messages',
           'choice_translation_domain' => 'messages',
           'attr' => array('class' => 'form-control'),
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'save',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'massive';
    }
}
