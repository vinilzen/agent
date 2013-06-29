<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\Point;
use Acme\SpyBundle\Entity\Franchise;
use Acme\SpyBundle\Form\PointType;
use Acme\SpyBundle\Controller\MissionController;

/**
 * Point controller.
 */
class PointController extends Controller
{
    /**
     * Lists all Point entities.
     *
     * @Route("/point/", name="point")
     * @Route("/point")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities_array = array();
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeSpyBundle:Point')->findAll();

        foreach ($entities as $entity) {
            $entities_array[] = array(
                'id'            =>  $entity->getId(),
                'title'         =>  $entity->getTitle(),
                'description'   =>  $entity->getDescription(),
                'active'        =>  $entity->getActive(),
                'latitude'      =>  $entity->getLatitude(),
                'longitude'     =>  $entity->getLongitude(),
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
     * @Route("/point/{latitude}x{longitude}/{distance}", name="nearest_point")
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
     * @Route("/franchise/{franchise_id}/point/", name="point_create")
     * @Method("POST")
     * @Template("AcmeSpyBundle:Point:new.html.twig")
     */
    public function createAction(Request $request, $franchise_id)
    {
        $response = new Response();
        $entity  = new Point();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PointType(), $entity);
        $form->bind($request);

        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            
            $json_string = MissionController::utf_cyr(json_encode('У вас нет доступа'));
            $response->setStatusCode(403);

        } else {

            $franchise = $em->getRepository('AcmeSpyBundle:Franchise')->find($franchise_id);

            if (!$franchise) {
                $json_string =  MissionController::utf_cyr(json_encode("Сеть не найдена"));
                $response->setStatusCode(404);

            } else {
                if ($form->isValid()) {

                    $em->persist($entity);
                    $entity->setFranchise($franchise );
                    $em->flush();
                    $json_string = json_encode(array('id' => $entity->getId()));
                    $response->setStatusCode(201); // created

                } else {

                    $validator = $this->get('validator');
                    $errors = $validator->validate($entity);
                    
                    $array = array();
                    $array['errors'] = array();
                    foreach ($errors as $error) {
                        $array['errors'][$error->getPropertyPath()] = $error->getMessage().' ('.$error->getInvalidValue().')';
                    }

                    $json_string = MissionController::utf_cyr(json_encode($array));
                    $response->setStatusCode(400);
                }
            }
        }

        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));
        $response->setContent($json_string);
        return $response;
    }

    /**
     * Finds and displays a Point entity.
     *
     * @Route("/point/{id}", name="point_show")
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
                'active'        =>  $entity->getActive(),
                'latitude'      =>  $entity->getLatitude(),
                'longitude'     =>  $entity->getLongitude(),
                'franchise'     =>  $entity->getFranchise()!=NULL?$entity->getFranchise()->getId():0
            );

            $json_string = json_encode($entity_array);
        }

        $json_string = MissionController::utf_cyr($json_string);

        $response->setContent($json_string);
        return $response;
    }

    /**
     * Edits an existing Point entity.
     *
     * @Route("/point/{id}", name="point_create")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSpyBundle:Point')->find($id);
                    
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            
            $json_string = MissionController::utf_cyr(json_encode('У вас нет доступа'));
            $response->setStatusCode(403);

        } else {

            if (!$entity) {
                $json_string = MissionController::utf_cyr(json_encode('Точка не найдена'));

                $response->setStatusCode(404);
                $response->setContent($json_string);
                
            } else {

                $editForm = $this->createForm(new PointType(), $entity);
                $editForm->bind($request);

                if ($editForm->isValid()) {
                    $param = $request->get('point');

                    var_dump($param); die;

                    if (array_key_exists('franchise', $param)){


                        $franchise_id = $param["franchise"];
                        $franchise = $em->getRepository('AcmeSpyBundle:Franchise')->find($franchise_id);

                        if (!$franchise) {
                            $json_string =  MissionController::utf_cyr(json_encode("Сеть не найдена (".$franchise_id.")"));
                            $response->setStatusCode(404);

                        } else {
                            $em->persist($entity);
                            $em->flush();
                            $json_string = json_encode($entity->getId());
                        }
                    } else {
                        var_dump($param); die;

                        $json_string =  MissionController::utf_cyr(json_encode("Неправильно указана сеть"));
                        $response->setStatusCode(404);
                    }

                } else {
                    $validator = $this->get('validator');
                    $errors = $validator->validate($entity);
                    
                    var_dump($errors); die;

                    $array = array();
                    $array['errors'] = array();
                    foreach ($errors as $error) {
                        $array['errors'][$error->getPropertyPath()] = $error->getMessage().' ('.$error->getInvalidValue().')';
                    }

                    $json_string = MissionController::utf_cyr(json_encode(serialize($errors)));
                    $response->setStatusCode(400);
                }
                
            }
        }

        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));
        $response->setContent($json_string);
        return $response;
    }

    /**
     * Deletes a Point entity.
     *
     * @Route("/point/{id}", name="point_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $response = new Response();

        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            
            $json_string = MissionController::utf_cyr(json_encode('У вас нет доступа'));
            $response->setStatusCode(403);

        } else {

            $form = $this->createDeleteForm($id);
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AcmeSpyBundle:Point')->find($id);

                if (!$entity) {
                    $json_string = MissionController::utf_cyr(json_encode('Точка не найдена'));

                    $response->setStatusCode(404);
                    $response->setContent($json_string);
                } else {
                    $em->remove($entity);
                    $em->flush();
                    $json_string = $id;
                }

            } else {

                $errors = $form->getErrors();
                $json_string = json_encode(serialize($errors));
                $response->setStatusCode(400);
            }
        }

        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        $response->setCache(array(
            'etag'          => 'abcdef',
            'last_modified' => new \DateTime(),
            'max_age'       => 0,
            's_maxage'      => 0,
            'private'       => false,
            'public'        => true,
        ));
        $response->setContent($json_string);
        return $response;
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
        return $this->createFormBuilder(array('id' => $id),array('csrf_protection' => false))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
