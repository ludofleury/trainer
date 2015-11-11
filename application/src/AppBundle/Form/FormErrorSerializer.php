<?php

namespace Playbloom\Trainer\AppBundle\Form;

use Symfony\Component\Form\FormInterface;

class FormErrorSerializer
{
    public static function serialize(FormInterface $form, &$collection = [], $prefix = null)
    {
        foreach ($form->getIterator() as $key => $child) {
            $field = $prefix ? sprintf('%s.%s', $prefix, $key) : $key;

            foreach ($child->getErrors() as $error) {
                $collection[] = ['field' => $field, 'messages' => $error->getMessage()];
            }

            if (count($child->getIterator()) > 0) {
                self::serialize($child, $collection, $field);
            }
        }

        return $collection;
    }
}
