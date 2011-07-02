<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vdvreede\TFrontendBundle\Entity\Transaction;
use Vdvreede\TFrontendBundle\Form\TransactionType;

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

        $limit = 20;
        $midRange = 7;

        $itemCount = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->countAllByUserAccount($this->getCurrentUser()->getId(), $account)->getQuery()->getSingleScalarResult();

        $paginator = new \Vdvreede\TFrontendBundle\Helper\Paginator($itemCount, $offset, $limit, $midRange);

        $entities = $em->getRepository('VdvreedeTFrontendBundle:Transaction')->findAllByUserAccount($this->getCurrentUser()->getId(), $account, ($offset - 1) * $limit, $limit)->getQuery()->execute();

        return array('entities' => $entities, 'paginator' => $paginator, 'account' => $account);
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

    /**
     * Performs the action.
     *
     * @Route("/go", name="transaction_action")
     * @Method("post")
     */
    public function actionAction() {
        
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                ->add('id', 'hidden')
                ->getForm()
        ;
    }

}
