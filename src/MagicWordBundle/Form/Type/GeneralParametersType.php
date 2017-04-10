<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class GeneralParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('homeText', TextareaType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'homeText',
            'required' => false,
        ));

        $builder->add('selfRegistration', CheckboxType::class, array(
            'label' => 'selfRegistration',
            'required' => false,
            'translation_domain' => 'messages',
        ));

        $builder->add('save', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'save',
            'translation_domain' => 'messages',
        ));

        $builder->setMethod('POST');
    }

    public function getName()
    {
        return 'general_parameters';
    }
}
