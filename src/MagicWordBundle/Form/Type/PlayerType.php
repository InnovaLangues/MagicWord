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
        ));

        $builder->add('language', EntityType::class, array(
           'class' => 'MagicWordBundle:Language',
           'choice_label' => 'name',
           'attr' => array('class' => 'form-control'),
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'submit',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'player';
    }
}
