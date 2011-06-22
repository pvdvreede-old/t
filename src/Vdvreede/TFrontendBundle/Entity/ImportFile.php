<?php

namespace Vdvreede\TFrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class ImportFile {

  protected $file;

  protected $importName;

  public function getFile() {
    return $this->file;
  }

  public function getImportName() {
    return $this->importName;
  }

}