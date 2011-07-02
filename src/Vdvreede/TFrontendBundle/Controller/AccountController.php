<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vdvreede\TFrontendBundle\Entity\Account;
use Vdvreede\TFrontendBundle\Form\AccountType;

/**
 * Account controller.
 *
 * @Route("/account")
 */
class AccountController extends BaseController {

    /**
     * Lists all Account entities.
     *
     * @Route("/", name="account", defaults={"offset" = "1"})
     * @Template()
     */
    public function indexAction($offset) {
        $em = $this->getDoctrine()->getEntityManager();

        $limit = 20;
        $midRange = 7;

        $itemCount = $em->getRepository('VdvreedeTFrontendBundle:Account')->countAllByUserId($this->getCurrentUser()->getId());

        $paginator = new \Vdvreede\TFrontendBundle\Helper\Paginator($itemCount, $offset, $limit, $midRange);

        $entities = $em->getRepository('VdvreedeTFrontendBundle:Account')->findAllByUserId($this->getCurrentUser()->getId(), ($offset - 1) * $limit, $limit);

        return array('entities' => $entities, 'paginator' => $paginator);
    }

    public function myAccountsAction($current) {

        $em = $this->getDoctrine()->getEntityManager();

        $accounts = $em->getRepository('VdvreedeTFrontendBundle:Account')->findAllByUserId($this->getCurrentUser()->getId())->getQuery()->execute();

        return $this->render('VdvreedeTFrontendBundle:Account:widget.html.twig', array(
            'current' => $current,
            'accounts' => $accounts
        ));
    }

    /**
     * Finds and displays a Account entity.
     *
     * @Route("/{id}/show", name="account_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Account entity.
     *
     * @Route("/new", name="account_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Account();
        $form = $this->createForm(new AccountType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Account entity.
     *
     * @Route("/create", name="account_create")
     * @Method("post")
     * @Template("VdvreedeTFrontendBundle:Account:new.html.twig")
     */
    public function createAction() {
        $entity = new Account();
        $request = $this->getRequest();
        $form = $this->createForm(new AccountType(), $entity);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $entity->setUser($this->getCurrentUser());

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('account_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Account entity.
     *
     * @Route("/{id}/edit", name="account_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $editForm = $this->createForm(new AccountType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Account entity.
     *
     * @Route("/{id}/update", name="account_update")
     * @Method("post")
     * @Template("VdvreedeTFrontendBundle:Account:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Account entity.');
        }

        $editForm = $this->createForm(new AccountType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $editForm->bindRequest($request);

            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('account_edit', array('id' => $id)));
            }
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Account entity.
     *
     * @Route("/{id}/delete", name="account_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $entity = $em->getRepository('VdvreedeTFrontendBundle:Account')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Account entity.');
                }

                $em->remove($entity);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('account'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                ->add('id', 'hidden')
                ->getForm()
        ;
    }

}
