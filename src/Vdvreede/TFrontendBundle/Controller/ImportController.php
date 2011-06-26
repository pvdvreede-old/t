<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vdvreede\TFrontendBundle\Entity\ImportFile;
use Vdvreede\TFrontendBundle\Form\ImportFileType;

class ImportController extends BaseController {

    private static $fileDirectory = '/tmp/';

    public function fileAction($accountId) {
        $fileImport = new \Vdvreede\TFrontendBundle\Entity\ImportFile();

        $fileForm = $this->createForm(new ImportFileType(), $fileImport);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $fileForm->bindRequest($request);

            if ($fileForm->isValid()) {

// move the file to a temp place
                $filename = $this->generateFileName();
                $fullFilename = self::$fileDirectory . $filename;
                $fileImport->getFile()->move(self::$fileDirectory, $filename);

// if an import type is selected then set the session and redirect to the next step
                if ($fileForm['importName']->getNormData() != '') {
                    $request->getSession()->set('import', $fullFilename);

                    return $this->forward('VdvreedeTFrontendBundle:Import:process', array(
                        'accountId' => $accountId,
                        'transImportId' => $fileForm['importName']->getNormData()
                    ));
                }

                $handle = fopen($fullFilename, 'r');

// create form and add items for each column
                $columnCount = count(fgetcsv($handle, 1000, ','));
                $mainForm = $this->createImportSetupForm($columnCount);

// finally if there have not been any errors, set the filename to the session
                $request->getSession()->set('import', $fullFilename);

                return $this->render('VdvreedeTFrontendBundle:Import:csv.html.twig', array(
                    'form' => $mainForm->createView(),
                    'accountId' => $accountId
                ));
            }
        }

        return $this->render('VdvreedeTFrontendBundle:Import:file.html.twig', array(
            'form' => $fileForm->createView()
        ));
    }

    public function processAction($accountId, $transImportId) {
        // check that account is owned by user before processing
        $em = $this->getDoctrine()->getEntityManager();
        $account = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($accountId, $this->getCurrentUser()->getId());

        $fullFilename = $this->getRequest()->getSession()->get('import');

        $handle = fopen($fullFilename, 'r');
        $columnCount = count(fgetcsv($handle, 1000, ','));
        fclose($handle);

        if ($transImportId == '0') {
            // get column count

            $form = $this->createImportSetupForm($columnCount);

            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {

                $transImport = new \Vdvreede\TFrontendBundle\Entity\TransImport();

                for ($i = 0; $i < $columnCount; $i++) {

                    if ($form['columns']['column' . $i]->getNormData() != '-1') {
                        $method = 'set' . $form['columns']['column' . $i]->getNormData() . 'Field';

                        $transImport->$method($i);
                    }
                }

                $transImport->setName($form['name']->getNormData());
                $transImport->setAccount($account);
                $transImport->setUser($this->getCurrentUser());

                $em->persist($transImport);
                $em->flush();
            } else {

                $this->getSession()->setFlash('error', 'There is an error in the form.');

                return $this->render('VdvreedeTFrontendBundle:Import:file.html.twig', array(
                    'form' => $form->createView()
                ));
            }
        } else {
            $transImport = $em->getRepository('VdvreedeTFrontendBundle:TransImport')->findOneByIdAndUser($transImportId, $this->getCurrentUser()->getId());
        }

        // initialise stat variables
        $inserted = 0;
        $errors = 0;
        $handle = fopen($fullFilename, 'r');

        // Run through the file and import the transactions
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) == $columnCount) {
                try {

                    $trans = new \Vdvreede\TFrontendBundle\Entity\Transaction();

                    $trans->setDescription($data[$transImport->getDescriptionField()]);
                    $trans->setMemo($data[$transImport->getMemoField()]);
                    $trans->setAmount($data[$transImport->getAmountField()]);
                    $trans->setDate(new \DateTime());

                    $trans->setUser($this->getCurrentUser());
                    $trans->setAccount($account);
                    $trans->setSplit(false);
                    $trans->setReportable(true);

                    $em->persist($trans);

                    $inserted++;
                } catch (Exception $ex) {
                    $errors++;
                }
            }
        }

        $em->flush();
        
        return $this->render('VdvreedeTFrontendBundle:Import:process.html.twig', array(
            'errors' => $errors,
            'inserted' => $inserted
        ));
    }

    private function createImportSetupForm($columnCount) {
        $columnFormType = new \Vdvreede\TFrontendBundle\Form\CsvSetupType();

        $columnFormType->setColumnCount($columnCount);

        $mainFormType = new \Vdvreede\TFrontendBundle\Form\ImportSetupType();

        $mainFormType->setColumnType($columnFormType);

// create main form and input column form
        return $this->createForm($mainFormType);
    }

    private function generateFileName() {
        return 'test.csv';
    }

}
