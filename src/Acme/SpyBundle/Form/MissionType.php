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
            ->add('active')
            ->add('costs')
            ->add('icons')
            ->add('description')
            ->add('point', 'entity', array(
                                              'label' => 'Точки',
                                              'class' => 'AcmeSpyBundle:Point',
                                              'expanded' => false
                                           ))
            ->add('missionType', 'entity', array(
                                                  'label' => 'Вопросы',
                                                  'class' => 'AcmeSpyBundle:missionType',
                                                  'expanded' => false
                                               ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\SpyBundle\Entity\Mission',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'mission';
    }
}
