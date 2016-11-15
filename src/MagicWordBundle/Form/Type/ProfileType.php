<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('profileText', TextareaType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'profile_text',
            'required' => false,
        ));

        $builder->add('profilePic', FileType::class, array(
            'attr' => array('class' => 'form-control'),
            'data_class' => null,
            'label' => 'profile_pic',
            'required' => false,
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
        return 'profile';
    }
}
