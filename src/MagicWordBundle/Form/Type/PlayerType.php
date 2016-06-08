<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('hidden', CheckboxType::class, array(
            'label' => 'hidden',
            'required' => false,
            'translation_domain' => 'messages',
        ));

        $builder->add('language', EntityType::class, array(
           'label' => 'game_language',
           'class' => 'MagicWordBundle:Language',
           'choice_label' => 'name',
           'attr' => array('class' => 'form-control'),
           'translation_domain' => 'messages',
           'choice_translation_domain' => 'messages',
        ));

        $builder->add('languageUI', EntityType::class, array(
            'label' => 'language_ui',
            'class' => 'MagicWordBundle:LanguageUI',
            'choice_label' => 'name',
            'attr' => array('class' => 'form-control'),
            'translation_domain' => 'messages',
            'choice_translation_domain' => 'messages',
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'save',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'player';
    }
}
