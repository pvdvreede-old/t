<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class CsvSetupType extends AbstractType
{
  private $columnCount;

  private static $columnNames = array(
    '-1' => 'Ignore Column',
    'Description' => 'Description',
    'Memo' => 'Memo',
    'Amount' => 'Amount',
    'Date' => 'Date'
  );

  public function buildForm(FormBuilder $builder, array $options)
  {
    for ($i = 0; $i < $this->columnCount; $i++) {
      $builder->add('column' . $i, 'choice', array(
                                                  'choices' => self::$columnNames
                                             ));
    }
  }

  public function setColumnCount($count)
  {
    $this->columnCount = $count;
  }
}