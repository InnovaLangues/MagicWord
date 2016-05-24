<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', TextType::class, array(
            'attr' => array('class' => 'form-control'),
        ));

        $builder->add('challenged', EntityType::class, array(
           'class' => 'MagicWordBundle:Player',
           'property' => 'username',
           'attr' => array('class' => 'form-control'),
       ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'generic.validate',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'challenge';
    }
}
