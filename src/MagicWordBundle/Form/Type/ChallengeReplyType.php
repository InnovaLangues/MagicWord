<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChallengeReplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('secondRoundType', EntityType::class, array(
          'class' => 'MagicWordBundle:RoundType\RoundType',
          'choice_label' => 'name',
          'attr' => array('class' => 'form-control'),
          'label' => 'round_type2',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default please-wait', 'data-message' => 'Génération de la grille.'),
            'label' => 'accept_challenge',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'challenge';
    }
}
