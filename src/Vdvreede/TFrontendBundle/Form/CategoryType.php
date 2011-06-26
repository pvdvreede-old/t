<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity\Category;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name')
                ->add('description')
                ->add('colour')
                ->add('type', 'choice', array(
                    'choices' => array(
                        Category::$INCOME => 'Income',
                        Category::$EXPENSE => 'Expense'
                    ),
                    'required' => true
                ))
                ->add('reportable')

        ;
    }

}