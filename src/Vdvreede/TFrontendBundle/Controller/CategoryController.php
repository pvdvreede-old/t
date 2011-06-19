<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $accounts = $em->getRepository('VdvreedeTFrontendBundle:Category')->findAllByUser($currentUser->getId());
        
        return $this->render('VdvreedeTFrontendBundle:Category:index.html.twig', array(
            'list' => $accounts
        ));
    }
    
    public function newAction()
    {
        $currentUser = $this->getCurrentUser();
        
        return $this->processCategory(new \Vdvreede\TFrontendBundle\Entity\Category, $currentUser, 'VdvreedeTFrontendBundle:Category:new.html.twig');                        
    }
    
    public function viewAction($itemId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $account = $em->getRepository('VdvreedeTFrontendBundle:Category')->findOneByIdAndUser($accountId, $currentUser->getId());
        
    }
    
    public function editAction($categoryId) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $currentUser = $this->getCurrentUser();
        
        $category = $em->getRepository('VdvreedeTFrontendBundle:Category')->findOneByIdAndUser($categoryId, $currentUser->getId());    

        return $this->processCategory($category, $currentUser, 'VdvreedeTFrontendBundle:Category:edit.html.twig');        
    }
    
    private function processCategory($category, $user, $view) {
        
        $form = $this->createForm(new \Vdvreede\TFrontendBundle\Form\CategoryType(), $category);

        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                $category->setUser($user);
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($category);
                $em->flush();
                
                $this->get('session')->setFlash('notice', 'Category has been created!');
            }
        }
        
        
        return $this->render($view, array(
            'form' => $form->createView(),
            'category' => $category
        ));
    }
    
    private function getCurrentUser() {
        return $this->get('security.context')->getToken()->getUser();
    }
}
