<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\Franchise;
use Acme\SpyBundle\Form\FranchiseType;

/**
 * Franchise controller.
 *
 * @Route("/franchise")
 */
class FranchiseController extends Controller
{
    /**
     * Lists all Franchise entities.
     *
     * @Route("/", name="franchise")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeSpyBundle:Franchise')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Franchise entity.
     *
     * @Route("/", name="franchise_create")
     * @Method("POST")
     * @Template("AcmeSpyBundle:Franchise:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Franchise();
        $form = $this->createForm(new FranchiseType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('franchise_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Franchise entity.
     *
     * @Route("/new", name="franchise_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Franchise();
        $form   = $this->createForm(new FranchiseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Franchise entity.
     *
     * @Route("/{id}", name="franchise_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Franchise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Franchise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Franchise entity.
     *
     * @Route("/{id}/edit", name="franchise_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Franchise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Franchise entity.');
        }

        $editForm = $this->createForm(new FranchiseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Franchise entity.
     *
     * @Route("/{id}", name="franchise_update")
     * @Method("PUT")
     * @Template("AcmeSpyBundle:Franchise:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Franchise')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Franchise entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FranchiseType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('franchise_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Franchise entity.
     *
     * @Route("/{id}", name="franchise_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSpyBundle:Franchise')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Franchise entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('franchise'));
    }

    /**
     * Creates a form to delete a Franchise entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
