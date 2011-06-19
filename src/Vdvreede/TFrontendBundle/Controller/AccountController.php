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
        $account = new \Vdvreede\TFrontendBundle\Entity\Account;
        
        $form = $this->createForm(new \Vdvreede\TFrontendBundle\Form\AccountType(), $account);
        
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                $account->setUser($this->get('security.context')->getToken()->getUser());
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($account);
                $em->flush();
                
                $this->get('session')->setFlash('notice', 'Account has been created!');
            }
        }
        
        
        return $this->render('VdvreedeTFrontendBundle:Account:new.html.twig', array(
            'form' => $form->createView()
        ));        
    }
}
