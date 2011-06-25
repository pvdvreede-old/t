<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TransactionController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $transactions = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findAllByUser($currentUser->getId());
        
        return $this->render('VdvreedeTFrontendBundle:Transaction:index.html.twig', array(
            'list' => $transactions
        ));
    }
    
    public function newAction()
    {
        $currentUser = $this->getCurrentUser();
        
        return $this->processTransaction(new \Vdvreede\TFrontendBundle\Entity\Transaction, $currentUser, 'VdvreedeTFrontendBundle:Transaction:new.html.twig');                        
    }
    
    public function viewAction($itemId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $trans = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findOneByIdAndUser($itemId, $currentUser->getId());
        
    }
    
    public function editAction($transId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $trans = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findOneByIdAndUser($transId, $currentUser->getId());    

        return $this->processTransaction($trans, $currentUser, 'VdvreedeTFrontendBundle:Transaction:edit.html.twig');        
    }
    
    private function processTransaction($trans, $user, $view) {
        
        $form = $this->createForm(new \Vdvreede\TFrontendBundle\Form\TransactionType(), $trans);

        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                $trans->setUser($user);
                $trans->setSplit(false);
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($trans);
                $em->flush();
                
                $this->get('session')->setFlash('notice', 'Transaction has been created!');
            }
        }
        
        
        return $this->render($view, array(
            'form' => $form->createView(),
            'transaction' => $trans
        ));
    }
    
    private function getCurrentUser() {
        return $this->get('security.context')->getToken()->getUser();
    }
}
