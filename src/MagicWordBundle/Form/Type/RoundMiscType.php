<?php

namespace MagicWordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RoundMiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'name',
            'translation_domain' => 'messages',
        ));

        $builder->add('description', TextType::class, array(
           'attr' => array('class' => 'form-control'),
           'label' => 'description',
           'translation_domain' => 'messages',
       ));
    }

    public function getName()
    {
        return 'roundmisc';
    }
}
