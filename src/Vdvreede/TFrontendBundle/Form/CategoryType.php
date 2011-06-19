<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('description', 'textarea');
        $builder->add('colour', 'text');
        $builder->add('reportable');
        $builder->add('type', 'choice', array(
            'choices' => array(
                Entity\Category::$INCOME => 'Income',
                Entity\Category::$EXPENSE => 'Expense'
                ),
            'required' => true
        ));
    }
}