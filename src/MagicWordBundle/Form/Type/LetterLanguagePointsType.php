<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LetterLanguagePointsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('point', IntegerType::class, array(
            'attr' => [
                'placeholder' => 'points',
                'translation_domain' => 'messages',
            ],
            'label' => 'points',
        ));

        $builder->add('weight', IntegerType::class, array(
            'attr' => [
                'placeholder' => 'weight',
                'translation_domain' => 'messages',
            ],
            'label' => 'weight',
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'save',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'wordLengthPoints';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MagicWordBundle\Entity\Letter\LetterLanguage',
        ));
    }
}
