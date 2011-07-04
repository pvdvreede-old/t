<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TransactionActionsType extends AbstractType
{
    public static $ACTION_DELETE = '1';
    public static $ACTION_MOVE = '2';
    public static $ACTION_CATEGORY = '3';
    
    private static $actionChoices = array(
        2 => 'Move transactions',
        1 => 'Delete transactions',
        3 => 'Set category'
    );
    
    private $categoryQuery;
    private $accountQuery;
    
    public function __construct($categoryQuery, $accountQuery) {      
        $this->categoryQuery = $categoryQuery;
        $this->accountQuery = $accountQuery;
    }   
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('action', 'choice', array(
                'choices' => self::$actionChoices
            ));
        
        $builder->add('category', 'entity', array(
            'class' => 'Vdvreede\\TFrontendBundle\\Entity\\Category',
            'query_builder' => $this->categoryQuery,
            'label' => 'Change category'
        ));
        
        $builder->add('account', 'entity', array(
            'class' => 'Vdvreede\\TFrontendBundle\\Entity\\Account',
            'query_builder' => $this->accountQuery,
            'label' => 'Change account'
        ));
        
    }
}