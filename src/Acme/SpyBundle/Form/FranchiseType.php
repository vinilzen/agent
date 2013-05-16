<?php

namespace Acme\SpyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logo')
            ->add('brand')
            ->add('industry')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\SpyBundle\Entity\Franchise',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'franchise';
    }
    /*
    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['csrf_protection'] = false;

        return $options;
    }
    */
}
