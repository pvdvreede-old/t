<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('description', 'textarea');
        $builder->add('type', 'choice', array(
            'choices' => array(
                Entity\Account::$SAVINGS => 'Savings',
                Entity\Account::$TRANSACTION => 'Transaction'
                ),
            'required' => true
        ));
    }
}