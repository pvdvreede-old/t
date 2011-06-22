<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImportController extends Controller
{
    public function fileAction($accountId)
    {       
	
        
        $form = $this->createForm(new Form\ImportFileType(), new Entity\ImportFile());

	return $this->render('VdvreedeTFrontendBundle:Import:file', array(
          'form' => $form->createView()
        ));
    }

    public function csvAction($accountId) {
       
      $file = new Entity\ImportFile(); 
      $form = $this->createForm(new Form\ImportFileType(), $file);

      $request = $this->get('request');

      $form->bindRequest($request);

      if ($form->isValid()) {
	$form['file']->move('/home/paul/', 'temp.csv');
     
        $handle = fopen('temp.csv', 'r');
        
        $i = 0;
        $count = 0;
        while ($data = fgetcsv($handle, 1000, ',') !== false && $i < 6) {
          $count = count($data);

        }
      }
    }
    
}
