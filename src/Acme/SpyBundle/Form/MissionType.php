<?php

namespace Acme\SpyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('runtime')
            ->add('needBuy')
            ->add('costs')
            ->add('icons')
            ->add('form')
            ->add('description')
            ->add('questions', 'collection', array(
                                                      'label' => 'Вопросы',
                                                      'type' => new QuestionType(),
                                                      'allow_add' => true,
                                                      'allow_delete' => true,
                                                      'prototype' => true
                                                 ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\SpyBundle\Entity\Mission'
        ));
    }

    public function getName()
    {
        return 'acme_spybundle_missiontype';
    }
}
