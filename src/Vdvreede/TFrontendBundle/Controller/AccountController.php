<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function indexAction()
    {
        
        
        
        return $this->render('VdvreedeTFrontendBundle:Default:index.html.twig');
    }
    
    public function newAction()
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();
        
        return $this->processAccount(new \Vdvreede\TFrontendBundle\Entity\Account, $currentUser, 'VdvreedeTFrontendBundle:Account:new.html.twig');                        
    }
    
    public function editAction($accountId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->get('security.context')->getToken()->getUser();
        
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
}
