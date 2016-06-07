<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'message',
            'translation_domain' => 'messages',
        ));

        $builder->add('challenged', EntityType::class, array(
           'class' => 'MagicWordBundle:Player',
           'attr' => array('class' => 'form-control'),
           'label' => 'challenged',
           'translation_domain' => 'messages',
       ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'save',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'challenge';
    }
}
