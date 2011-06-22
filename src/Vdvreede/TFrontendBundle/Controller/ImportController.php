<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vdvreede\TFrontendBundle\Entity\ImportFile;
use Vdvreede\TFrontendBundle\Form\ImportFileType;

class ImportController extends Controller
{
    public function fileAction($accountId)
    {       	        
        $form = $this->createForm(new ImportFileType(), new ImportFile());

	return $this->render('VdvreedeTFrontendBundle:Import:file.html.twig', array(
          'form' => $form->createView()
        ));
    }

    public function csvAction($accountId) {
       
      $file = new ImportFile(); 
      $form = $this->createForm(new ImportFileType(), $file);

      $request = $this->get('request');

      $form->bindRequest($request);

      if ($form->isValid()) {
	$form['file']->move('/home/paul/', 'temp.csv');
     
        $handle = fopen('/home/paul/temp.csv', 'r');
        
        $i = 0;
        $count = 0;
        while ($data = fgetcsv($handle, 1000, ',') !== false && $i < 6) {
          $count = count($data);

        }
      }
    }
    
}
