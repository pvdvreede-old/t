<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class ImportFileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('file', 'file');
        $builder->add('import_name', 'entity', array(
            'class' => 'Vdvreede\\TFrontendBundle\\Entity\\TransImport',
            'query_builder' => function($er) {
                return $er->createQueryBuilder('i')
                          ->where('userId = :userId)
                          ->andWhere('accountId = :accountId')
                          ->setParameter('userId', 1)
                          ->setParameter('accountId', 1);
             },
             'multiple' => false,
             'required' => false,
             'label' => 'Import type to use'
        ));	

    }
}