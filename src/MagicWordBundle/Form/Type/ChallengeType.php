<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
           'query_builder' => function (EntityRepository $er) use ($options) {
                return $er->getCandidates($options['user']);
            },
            'required' => true,
            'placeholder' => '----------',
           'attr' => array('class' => 'form-control'),
           'label' => 'challenged',
           'translation_domain' => 'messages',
       ));

        $builder->add('firstRoundType', EntityType::class, array(
          'class' => 'MagicWordBundle:RoundType\RoundType',
          'choice_label' => 'name',
          'attr' => array('class' => 'form-control'),
          'label' => 'round_type',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
      ));

        $builder->add('language', EntityType::class, array(
        'class' => 'InnovaLexiconBundle:Language',
        'choice_label' => 'name',
        'attr' => array('class' => 'form-control'),
        'label' => 'language',
        'translation_domain' => 'messages',
        'choice_translation_domain' => 'messages',
    ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'challenge!',
            'translation_domain' => 'messages',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'user' => null,
        ));
    }

    public function getName()
    {
        return 'challenge';
    }
}
