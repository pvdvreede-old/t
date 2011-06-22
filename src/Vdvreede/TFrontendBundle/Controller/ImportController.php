<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImportController extends Controller
{
    public function fileAction($accountId)
    {       
	$file = new Entity\ImportFile();
        
        $form = $this->createForm(new Form\ImportFileType(), new Entity\ImportFile());

	return $this->render('VdvreedeTFrontendBundle:Import:file', array(
          'form' => $form->createView()
        ));
    }

    public function csvAction($accountId) {

    }
    
}
