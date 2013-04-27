<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\Mission;
use Acme\SpyBundle\Form\MissionType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Mission controller.
 *
 * @Route("/mission")
 */
class MissionController extends Controller
{
    /**
     * Lists all Mission entities.
     *
     * @Route("/", name="mission")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeSpyBundle:Mission')->findAll();

        //return array('entities' => $entities);

        //var_dump($entities); die();

        // return json with clear cache        
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");// дата в прошлом
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // всегда модифицируется
        header("Cache-Control: no-store, no-cache, must-revalidate");// HTTP/1.1
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");// HTTP/1.0
        
        $result = array('data' => $entities, 'code' => 200);
        return $this->render('AcmeSpyBundle::API.json.twig', array('result' => $result));
    }

    /**
     * Creates a new Mission entity.
     *
     * @Route("/", name="mission_create")
     * @Method("POST")
     * @Template("AcmeSpyBundle:Mission:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Mission();
        $form = $this->createForm(new MissionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mission_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Mission entity.
     *
     * @Route("/new", name="mission_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mission();
        $form   = $this->createForm(new MissionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mission entity.
     *
     * @Route("/{id}", name="mission_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mission entity.
     *
     * @Route("/{id}/edit", name="mission_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $editForm = $this->createForm(new MissionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Mission entity.
     *
     * @Route("/{id}", name="mission_update")
     * @Method("PUT")
     * @Template("AcmeSpyBundle:Mission:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MissionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mission_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Mission entity.
     *
     * @Route("/{id}", name="mission_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSpyBundle:Mission')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mission entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mission'));
    }

    /**
     * Creates a form to delete a Mission entity by id.
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
