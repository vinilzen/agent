<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\MissionAccomplished;
use Acme\SpyBundle\Form\MissionAccomplishedType;

/**
 * MissionAccomplished controller.
 *
 * @Route("/complet")
 */
class MissionAccomplishedController extends Controller
{
    /**
     * Lists all MissionAccomplished entities.
     *
     * @Route("/", name="complet")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities_array = array();
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeSpyBundle:MissionAccomplished')->findAll();

        foreach ($entities as $entity) {
            $entities_array[] = array(
                'id'            =>  $entity->getId(),
                'latitude'      =>  $entity->getLatitude(),
                'longitude'     =>  $entity->getLongitude(),
                'info'          =>  $entity->getInfo(),
                'status'        =>  $entity->getStatus(),
                'files'         =>  $entity->getFiles()
            );
        }

        $json_string = MissionController::utf_cyr(json_encode($entities_array));

        $response = new Response();
        $response->setContent($json_string);
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));

        return $response;
    }

    /**
     * Creates a new MissionAccomplished entity.
     *
     * @Route("/", name="complet_create")
     * @Method("POST")
     * @Template("AcmeSpyBundle:MissionAccomplished:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new MissionAccomplished();
        $form = $this->createForm(new MissionAccomplishedType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('complet_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new MissionAccomplished entity.
     *
     * @Route("/new", name="complet_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MissionAccomplished();
        $form   = $this->createForm(new MissionAccomplishedType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MissionAccomplished entity.
     *
     * @Route("/{id}", name="complet_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:MissionAccomplished')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MissionAccomplished entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MissionAccomplished entity.
     *
     * @Route("/{id}/edit", name="complet_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:MissionAccomplished')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MissionAccomplished entity.');
        }

        $editForm = $this->createForm(new MissionAccomplishedType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing MissionAccomplished entity.
     *
     * @Route("/{id}", name="complet_update")
     * @Method("PUT")
     * @Template("AcmeSpyBundle:MissionAccomplished:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:MissionAccomplished')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MissionAccomplished entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MissionAccomplishedType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('complet_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a MissionAccomplished entity.
     *
     * @Route("/{id}", name="complet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSpyBundle:MissionAccomplished')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MissionAccomplished entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('complet'));
    }

    /**
     * Creates a form to delete a MissionAccomplished entity by id.
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
