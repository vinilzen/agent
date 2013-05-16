<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\Point;
use Acme\SpyBundle\Form\PointType;
use Acme\SpyBundle\Controller\MissionController;

/**
 * Point controller.
 *
 * @Route("/point")
 */
class PointController extends Controller
{
    /**
     * Lists all Point entities.
     *
     * @Route("/", name="point")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeSpyBundle:Point')->findAll();

        foreach ($entities as $entity) {
            $entities_array[] = array(
                'id'            =>  $entity->getId(),
                'title'         =>  $entity->getTitle(),
                'description'   =>  $entity->getDescription(),
                'latitude'   =>  $entity->getLatitude(),
                'longitude'   =>  $entity->getLongitude(),
                'franchise'     =>  $entity->getFranchise()!=NULL?$entity->getFranchise()->getId():0
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
     * Lists The Nearest Points Point entities.
     *
     * @Route("/{latitude}x{longitude}/{distance}", name="nearest_point")
     * @Method("GET")
     * @Template()
     */
    public function nearest_pointAction($latitude, $longitude, $distance)
    {
        $em = $this->getDoctrine()->getManager();

        /*
         * return array [{id, title, latitude, longitude, distance}, ...]
         */
        $results = $em
                    ->getRepository('AcmeSpyBundle:Point')
                    ->findTheNearestPoints($latitude, $longitude, $distance);

        
        if (count($results)){
            foreach ($results as $point) {
                $entities_array[] = array(
                    'id'            =>  $point['id'],
                    'title'         =>  $point['title'],
                    'distance'      =>  round($point['distance']),
                    'latitude'      =>  $point['latitude'],
                    'longitude'     =>  $point['longitude']
                );
            }

            $json_string = MissionController::utf_cyr(json_encode($entities_array));
       
        } else {

            $json_string = MissionController::utf_cyr(json_encode('В радиусе '.$distance.'м заведений не обнаружено.'));

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
     * Creates a new Point entity.
     *
     * @Route("/", name="point_create")
     * @Method("POST")
     * @Template("AcmeSpyBundle:Point:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Point();
        $form = $this->createForm(new PointType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('point_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Point entity.
     *
     * @Route("/new", name="point_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Point();
        $form   = $this->createForm(new PointType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Point entity.
     *
     * @Route("/{id}", name="point_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSpyBundle:Point')->find($id);

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
            $json_string = json_encode('Точка не найдена');
            $response->setStatusCode(404);
        } else {
            $entity_array = array(
                'id'            =>  $entity->getId(),
                'title'         =>  $entity->getTitle(),
                'description'   =>  $entity->getDescription(),
                'coordinates'   =>  $entity->getCoordinates(),
                'franchise'     =>  $entity->getFranchise()!=NULL?$entity->getFranchise()->getId():0
            );

            $json_string = json_encode($entity_array);
        }

        $json_string = MissionController::utf_cyr($json_string);

        $response->setContent($json_string);
        return $response;
    }

    /**
     * Displays a form to edit an existing Point entity.
     *
     * @Route("/{id}/edit", name="point_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Point')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Point entity.');
        }

        $editForm = $this->createForm(new PointType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Point entity.
     *
     * @Route("/{id}", name="point_update")
     * @Method("PUT")
     * @Template("AcmeSpyBundle:Point:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Point')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Point entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PointType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('point_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Point entity.
     *
     * @Route("/{id}", name="point_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSpyBundle:Point')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Point entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('point'));
    }

    /**
     * Creates a form to delete a Point entity by id.
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
