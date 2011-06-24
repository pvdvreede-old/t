<?php

namespace Vdvreede\TFrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Vdvreede\TFrontendBundle\Entity;

class CsvSetupType extends AbstractType
{
  private $columnCount;

  private static $columnNames = array(
    '0' => 'Ignore Column',
    '1' => 'Description',
    '2' => 'Memo',
    '3' => 'Amount',
    '4' => 'Date'
  );

  public function buildForm(FormBuilder $builder, array $options)
  {
    for ($i = 1; $i < $this->columnCount; $i++) {
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