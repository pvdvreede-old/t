<?php

namespace Vdvreede\TFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vdvreede\TFrontendBundle\Entity\Category;
use Vdvreede\TFrontendBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends BaseController {

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category", defaults={"offset" = "1"})
     * @Template()
     */
    public function indexAction($offset) {
        $em = $this->getDoctrine()->getEntityManager();

        $limit = 20;
        $midRange = 7;

        $itemCount = $em->getRepository('VdvreedeTFrontendBundle:Category')->countAllByUserId($this->getCurrentUser()->getId());

        $paginator = new \Vdvreede\TFrontendBundle\Helper\Paginator($itemCount, $offset, $limit, $midRange);

        $entities = $em->getRepository('VdvreedeTFrontendBundle:Category')->findAllByUserId($this->getCurrentUser()->getId(), ($offset - 1) * $limit, $limit);

        return array('entities' => $entities, 'paginator' => $paginator);
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="category_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Category')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Template()
     */
    public function newAction() {
        $entity = new Category();
        $form = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="category_create")
     * @Method("post")
     * @Template("VdvreedeTFrontendBundle:Category:new.html.twig")
     */
    public function createAction() {
        $entity = new Category();
        $request = $this->getRequest();
        $form = $this->createForm(new CategoryType(), $entity);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $entity->setUser($this->getCurrentUser());

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Category')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="category_update")
     * @Method("post")
     * @Template("VdvreedeTFrontendBundle:Category:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('VdvreedeTFrontendBundle:Category')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $editForm->bindRequest($request);

            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
            }
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="category_delete")
     * @Method("post")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $entity = $em->getRepository('VdvreedeTFrontendBundle:Category')->findOneByIdAndUser($id, $this->getCurrentUser()->getId());

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Category entity.');
                }

                $em->remove($entity);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('category'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                ->add('id', 'hidden')
                ->getForm()
        ;
    }

}
