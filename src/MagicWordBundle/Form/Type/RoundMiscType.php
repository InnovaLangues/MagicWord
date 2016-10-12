<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RoundMiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'name',
            'translation_domain' => 'messages',
        ));

        $builder->add('description', TextType::class, array(
           'attr' => array('class' => 'form-control'),
           'label' => 'description',
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
    }

    public function getName()
    {
        return 'roundmisc';
    }
}
