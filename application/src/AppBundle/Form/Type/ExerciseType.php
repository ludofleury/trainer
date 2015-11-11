<?php

namespace Playbloom\Trainer\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('reps', 'integer')
            ->add('sets', 'integer')
            ->add('rest', 'integer')
            ->add('description', 'text')
        ;
    }


    public function configureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Playbloom\Trainer\AppBundle\Entity\Exercise',
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'exercise_type';
    }

}