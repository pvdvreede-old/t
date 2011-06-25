<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class ImportSetupType extends AbstractType
{

  private $columnFormType;

  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name', 'text');
    $builder->add('has_header', 'checkbox');
    $builder->add('columns', $this->columnFormType);
  }

  public function setColumnType($columnType)
  {
    $this->columnFormType = $columnType;
  }

}