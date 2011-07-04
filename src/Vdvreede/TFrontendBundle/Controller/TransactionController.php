<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vdvreede\TFrontendBundle\Entity\Transaction;
use Vdvreede\TFrontendBundle\Form\TransactionType;
use Vdvreede\TFrontendBundle\Form\TransactionActionsType;

/**
 * Transaction controller.
 *
 * @Route("/transaction")
 */
class TransactionController extends BaseController {

    /**
     * Lists all Transaction entities.
     *
     * @Route("/{account}/{offset}", name="transaction", defaults={"offset" = "1", "account" = "0"})
     * @Template()
     */
    public function indexAction($offset, $account) {
        $em = $this->getDoctrine()->getEntityManager();
        
        // process actions first
        $request = $this->getRequest();
        
        $actionForm = $this->createForm(new TransactionActionsType($em->getRepository('VdvreedeTFrontendBundle:Category')->findAllByUserId($this->getCurrentUser()->getId()), $em->getRepository('VdvreedeTFrontendBundle:Account')->findAllByUserId($this->getCurrentUser()->getId()))); 
        
        if ($request->getMethod() == 'POST') {
            
            $actionForm->bindRequest($request);
            
            if ($actionForm->isValid()) {
                
                switch ($actionForm['action']->getNormData()) {
                    
                    case \Vdvreede\TFrontendBundle\Form\TransactionActionsType::$ACTION_DELETE:
                        $this->deleteTransactions($request->request->get('trans_id'));
                        break;
                    
                    case \Vdvreede\TFrontendBundle\Form\TransactionActionsType::$ACTION_MOVE:
                        $this->moveTransactions($request->request->get('trans_id'), $actionForm['account']->getNormData());
                        break;
                    
                    case \Vdvreede\TFrontendBundle\Form\TransactionActionsType::$ACTION_CATEGORY:
                        $this->changeCategory($request->request->get('trans_id'), $actionForm['category']->getNormData());
                        break;
                }
                
            }
            
        }
        
        $limit = 20;
        $midRange = 7;

        $itemCount = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->countAllByUserAccount($this->getCurrentUser()->getId(), $account)->getQuery()->getSingleScalarResult();

        $paginator = new \Vdvreede\TFrontendBundle\Helper\Paginator($itemCount, $offset, $limit, $midRange);

        $entities = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findAllByUserAccount($this->getCurrentUser()->getId(), $account, ($offset - 1) * $limit, $limit)->getQuery()->execute();

        return array('entities' => $entities, 'paginator' => $paginator, 'account' => $account, 'form' => $actionForm->createView());
    }

    /**
     * Finds and displays a Transaction entity.
     *
     * @Route("/{id}/show", name="transaction_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transaction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Transaction entity.
     *
     * @Route("/new", name="transaction_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Transaction();
        $form = $this->createForm(new TransactionType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Transaction entity.
     *
     * @Route("/create", name="transaction_create")
     * @Method("post")
     * @Template("VdvreedeTFrontendBundle:Transaction:new.html.twig")
     */
    public function createAction() {
        $entity = new Transaction();
        $request = $this->getRequest();
        $form = $this->createForm(new TransactionType(), $entity);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {

                $entity->setUser($this->getCurrentUser());

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('transaction_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Transaction entity.
     *
     * @Route("/{id}/edit", name="transaction_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transaction entity.');
        }

        $editForm = $this->createForm(new TransactionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Transaction entity.
     *
     * @Route("/{id}/update", name="transaction_update")
     * @Method("post")
     * @Template("VdvreedeTFrontendBundle:Transaction:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transaction entity.');
        }

        $editForm = $this->createForm(new TransactionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $editForm->bindRequest($request);

            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('transaction_edit', array('id' => $id)));
            }
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Transaction entity.
     *
     * @Route("/{id}/delete", name="transaction_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $entity = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Transaction entity.');
                }

                $em->remove($entity);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('transaction'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                ->add('id', 'hidden')
                ->getForm()
        ;
    }
    
    private function deleteTransactions($ids) {
        $em = $this->getDoctrine()->getEntityManager();
        
        $query = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->deleteByUserAndIds($this->getCurrentUser()->getId(), $ids)->getQuery();
        
        $rows = $query->execute();

        $this->get('session')->setFlash('notice', $rows.' transactions have been deleted.');
        
        $this->redirect($this->getRequest()->getPathInfo());
    }
    
    private function moveTransactions($ids, $account) {
        $em = $this->getDoctrine()->getEntityManager();
        
        $query = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->updateByUserId($this->getCurrentUser()->getId(), $ids, array('accountId' => $account->getId()))->getQuery();
        
        $rows = $query->execute();

        $this->get('session')->setFlash('notice', $rows.' transactions have been updated.');
        
        $this->redirect($this->getRequest()->getPathInfo());
    }
    
    private function changeCategory($ids, $category) {
        $em = $this->getDoctrine()->getEntityManager();
        
        $query = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->updateByUserId($this->getCurrentUser()->getId(), $ids, array('categoryId' => $category->getId()))->getQuery();
        
        $rows = $query->execute();

        $this->get('session')->setFlash('notice', $rows.' transactions have been updated.');
        
        $this->redirect($this->getRequest()->getPathInfo());
    }

}
