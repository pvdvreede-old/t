<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class ImportSetupType extends AbstractType {

    private $columnFormType;
    private static $dateFormats = array(
        'Y-m-d' => 'Y-m-d (eg 2001-03-23)',
        'd-m-Y' => 'd-m-Y (eg 15-03-2011)',
        'm-d-Y' => 'm-d-Y (eg 03-14-2011)',
        'Y/m/d' => 'Y/m/d (eg 2001/03/23)',
        'd/m/Y' => 'd/m/Y (eg 15/03/2011)',
        'm/d/Y' => 'm/d/Y (eg 03/14/2011)'
    );

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name', 'text');
        $builder->add('has_header', 'checkbox', array(
            'required' => false
        ));
        $builder->add('date_format', 'choice', array(
            'choices' => self::$dateFormats
        ));
        $builder->add('columns', $this->columnFormType);
    }

    public function setColumnType($columnType) {
        $this->columnFormType = $columnType;
    }

}