<?php

namespace MagicWordBundle\Form\Type\ObjectiveType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FindWordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('inflection', TextType::class, array(
                'attr' => [
                    'data-field' => 'inflection',
                    'pattern' => '[A-Za-z]+',
                    'placeholder' => 'form',
                    'translation_domain' => 'messages',
                ],
            )
        );

        $builder->add('hint', TextType::class, array(
            'attr' => [
                'data-field' => 'hint',
                'placeholder' => 'hint',
                'translation_domain' => 'messages',
            ],
        ));
    }

    public function getName()
    {
        return 'findword';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MagicWordBundle\Entity\ObjectiveType\FindWord',
        ));
    }
}
