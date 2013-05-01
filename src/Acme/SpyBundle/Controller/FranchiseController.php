<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\Franchise;
use Acme\SpyBundle\Form\FranchiseType;
use Acme\SpyBundle\Controller\MissionController;

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

        foreach ($entities as $entity) {
            $entities_array[] = array(
                'id' => $entity->getId(),
                'brand' => $entity->getBrand(),
                'industry' => $entity->getIndustry()
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

            $json_string = json_encode($entity->getId());
        } else {
            $json_string = json_encode('Неверный запрос');
        }


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

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));

        if (!$entity) {
            $json_string = json_encode('Сеть не найдена');
            $response->setStatusCode(404);
        } else {
            $entity_array = array(
                'id' => $entity->getId(),
                'brand' => $entity->getBrand(),
                'industry' => $entity->getIndustry()
            );

            $json_string = json_encode($entity_array);
        }
        
        $json_string = MissionController::utf_cyr($json_string);

        $response->setContent($json_string);
        return $response;
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
            $json_string = MissionController::utf_cyr(json_encode('Сеть не найдена'));
            
            $response = new Response();
            $response->setStatusCode(404);
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


        $response = new Response();
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));

        if (!$entity) {
            $json_string = MissionController::utf_cyr(json_encode('Сеть не найдена'));
            
            $response->setStatusCode(404);
            $response->setContent($json_string);
            return $response;
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new FranchiseType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $json_string = json_encode($entity->getId());
        } else {
            $json_string = json_encode('Неверный запрос');
            $response->setStatusCode(400);
        }

        $response->setContent($json_string);
        return $response;
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

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSpyBundle:Franchise')->find($id);

            if (!$entity) {
                $json_string = MissionController::utf_cyr(json_encode('Сеть не найдена'));
                
                $response->setStatusCode(404);
                $response->setContent($json_string);
                
                return $response;
            }

            $em->remove($entity);
            $em->flush();
            $json_string = $id;
        } else {
            $json_string = json_encode('Неверный запрос');
        }

        $response->setContent($json_string);

        return $response;
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
