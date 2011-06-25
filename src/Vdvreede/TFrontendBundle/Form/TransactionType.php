<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('description', 'textarea')
            ->add('memo')
            ->add('date')
            ->add('amount')
            ->add('split')
            ->add('reportable')
            ->add('account')
            ->add('category')
            ->add('parentTransaction')
        ;
    }
}