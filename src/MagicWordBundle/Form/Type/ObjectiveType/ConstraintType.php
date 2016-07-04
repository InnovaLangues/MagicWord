<?php

namespace MagicWordBundle\Form\Type\ObjectiveType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConstraintType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numberToFind', IntegerType::class,  array(
            'label' => 'constraint_number',
            'translation_domain' => 'messages',
            'attr' => [
                'data-field' => 'number',
            ],
        ));

        $builder->add('category', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Category',
          'placeholder' => '- category -',
          'required' => false,
          'empty_data' => null,
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'category',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));

        $builder->add('number', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Number',
          'placeholder' => '- number -',
          'required' => false,
          'empty_data' => null,
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'number',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));

        $builder->add('gender', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Gender',
          'placeholder' => '- gender -',
          'required' => false,
          'empty_data' => null,
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'gender',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));

        $builder->add('tense', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Tense',
          'placeholder' => '- tense -',
          'required' => false,
          'empty_data' => null,
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'tense',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));

        $builder->add('person', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Person',
          'placeholder' => '- person -',
          'required' => false,
          'empty_data' => null,
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'person',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));

        $builder->add('mood', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Mood',
          'placeholder' => '- mood -',
          'required' => false,
          'empty_data' => null,
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'mood',
          'translation_domain' => 'messages',
          'choice_translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'constraint';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MagicWordBundle\Entity\ObjectiveType\Constraint',
        ));
    }
}
