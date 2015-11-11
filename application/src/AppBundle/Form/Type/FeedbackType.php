<?php

namespace Playbloom\Trainer\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('set', 'integer')
            ->add('reps', 'integer')
            ->add('weight', 'integer')
            ->add('feeling', 'int')
            ->add('comment', 'text')
        ;
    }


    public function configureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Playbloom\Trainer\AppBundle\Entity\Feedback',
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