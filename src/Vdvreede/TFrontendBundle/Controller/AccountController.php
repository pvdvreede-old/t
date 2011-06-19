<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $accounts = $em->getRepository('VdvreedeTFrontendBundle:Account')->findAllByUser($currentUser->getId());
        
        return $this->render('VdvreedeTFrontendBundle:Account:index.html.twig', array(
            'list' => $accounts
        ));
    }
    
    public function newAction()
    {
        $currentUser = $this->getCurrentUser();
        
        return $this->processAccount(new \Vdvreede\TFrontendBundle\Entity\Account, $currentUser, 'VdvreedeTFrontendBundle:Account:new.html.twig');                        
    }
    
    public function viewAction($itemId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $account = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($accountId, $currentUser->getId());
        
    }
    
    public function editAction($accountId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $account = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($accountId, $currentUser->getId());    

        return $this->processAccount($account, $currentUser, 'VdvreedeTFrontendBundle:Account:edit.html.twig');        
    }
    
    private function processAccount($account, $user, $view) {
        
        $form = $this->createForm(new \Vdvreede\TFrontendBundle\Form\AccountType(), $account);

        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                $account->setUser($user);
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($account);
                $em->flush();
                
                $this->get('session')->setFlash('notice', 'Account has been created!');
            }
        }
        
        
        return $this->render($view, array(
            'form' => $form->createView(),
            'account' => $account
        ));
    }
    
    private function getCurrentUser() {
        return $this->get('security.context')->getToken()->getUser();
    }
}
