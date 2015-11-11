<?php

namespace Playbloom\Trainer\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('month', 'integer')
        ;
    }


    public function configureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Playbloom\Trainer\AppBundle\Entity\Program',
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'program_type';
    }

}