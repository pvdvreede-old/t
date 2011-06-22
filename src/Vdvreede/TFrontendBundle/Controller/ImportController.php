<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vdvreede\TFrontendBundle\Entity\ImportFile;
use Vdvreede\TFrontendBundle\Form\ImportFileType;

class ImportController extends Controller {

    public static $columnNames = array(
        1 => 'Description',
        2 => 'Memo',
        3 => 'Amount',
        4 => 'Date'
    );
    
    public function fileAction($accountId) {
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
            $file->getFile()->move('/home/paul/', 'temp.csv');

            if ($file->getImportName() != "") {
                
            } else {

                $handle = fopen('/home/paul/temp.csv', 'r');
                throw new \Symfony\Component\Config\Definition\Exception\Exception();
                $i = 0;
                $count = count(fgetcsv($handle, 1000, ','));
                
                $form = $this->createFormBuilder();
                
                for ($i = 0; $i < $count; $i++) {
                    $form->add($i, 'choice', array(
                        'choices' => self::$columnNames
                    )); 
                }
                
                
                return $this->render('VdvreedeTFrontend:Import:csv.html.twig', array(
                    'form' => $form->createView()
                ));
            }
        }
        
        $this->get('session')->setFlash('error', 'The file could not be imported!');
        
        $this->redirect('import_file');
    }

}
