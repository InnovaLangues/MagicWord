<?php

namespace MagicWordBundle\Form\Type\ObjectiveType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ComboType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lenght', IntegerType::class,  array(
            'attr' => [
                'data-field' => 'lenght',
                'placeholder' => 'Longueur',
            ],
        ));

        $builder->add('number', IntegerType::class,  array(
            'attr' => [
                'data-field' => 'number',
                'placeholder' => 'Nombre de combos',
            ],
        ));
    }

    public function getName()
    {
        return 'combo';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MagicWordBundle\Entity\ObjectiveType\Combo',
        ));
    }
}
