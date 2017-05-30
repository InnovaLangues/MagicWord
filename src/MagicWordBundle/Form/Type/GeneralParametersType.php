<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class GeneralParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('homeText', TextareaType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'homeText',
            'required' => false,
        ));

        $builder->add('piwikUrl', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'piwikUrl',
            'required' => false,
        ));

        $builder->add('selfRegistration', CheckboxType::class, array(
            'label' => 'selfRegistration',
            'required' => false,
            'translation_domain' => 'messages',
        ));

        $builder->add('tutorial', EntityType::class, array(
          'class' => 'MagicWordBundle:Game',
          'choice_label' => 'id',
          'attr' => array('class' => 'form-control'),
          'label' => 'tutorial_game_id',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));


        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'save',
            'translation_domain' => 'messages',
        ));

        $builder->setMethod('POST');
    }

    public function getName()
    {
        return 'general_parameters';
    }
}
