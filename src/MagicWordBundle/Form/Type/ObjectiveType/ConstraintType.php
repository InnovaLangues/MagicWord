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
        $builder->add('number', IntegerType::class,  array(
            'label' => 'constraint_number',
            'translation_domain' => 'messages',
            'attr' => [
                'data-field' => 'number',
            ],
        ));

        $builder->add('category', EntityType::class, array(
          'class' => 'MagicWordBundle:Lexicon\Category',
          'choice_label' => 'value',
          'attr' => array('class' => 'form-control'),
          'label' => 'category',
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
