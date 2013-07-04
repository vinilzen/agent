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
     * @Route("/points", name="nearest_point")
     * @Method("GET")
     * @Template()
     */
    public function nearest_pointAction(Request $request)
    {
    // example  /app_dev.php/points?distance=1500&location[latitude]=55.777033&location[longitude]=37.583138

        $location = $request->query->get('location');
        $distance = $request->query->get('distance');
        $em = $this->getDoctrine()->getManager();

        /*
         * return array [{id, title, latitude, longitude, distance}, ...]
         */
        $results = $em
                    ->getRepository('AcmeSpyBundle:Point')
                    ->findTheNearestPoints($location['latitude'], $location['longitude'], $distance);

        
        if (count($results)){
            foreach ($results as $point) {
                $tasks_id = array();
                $tasks = $em->getRepository('AcmeSpyBundle:Mission')->findByPoint($point['id']);
                if (count($tasks)){
                    foreach ($tasks as $task) {
                        array_push($tasks_id, $task->getId());
                    }
                }
                $entities_array[] = array(
                    'id'            =>  $point['id'],
                    'title'         =>  $point['title'],
                    'distance'      =>  round($point['distance']),
                    'latitude'      =>  $point['latitude'],
                    'longitude'     =>  $point['longitude'],
                    'tasks'         =>  $tasks_id
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
    /*
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

                    $array['errors'] = array();
                    $errors = $this->get('validator')->validate($entity);

                    if(count($errors) == 0){
                        $errors = $editForm->getErrors();

                        foreach ($errors as $key => $error) {
                            $template = $error->getMessageTemplate();
                            $parameters = $error->getMessageParameters();

                            foreach($parameters as $var => $value){
                                $template = str_replace($var, $value, $template);
                            }

                            $array['errors'][$key] = $template;
                        }

                    } else {

                        foreach ($errors as $error) {
                            $array['errors'][$error->getPropertyPath()] = $error->getMessage().' ('.$error->getInvalidValue().')';
                        }

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
    }*/

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
     * @Route("/point/{id}", name="point_update")
     * @Route("/point/", defaults={"id"=0})
     * @Method("PUT")
     */
    /*
    public function updateAction(Request $request, $id)
    {
        $response = new Response();
        
        if ($id==0){
            $json_string =  MissionController::utf_cyr(json_encode("Неправильный путь"));
            $response->setStatusCode(400);
        } else {
            $param = $request->get('point');
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

                    if (array_key_exists('franchise', $param)){

                        $franchise_id = $param["franchise"];

                        if ($franchise_id != '')
                            $franchise = $em->getRepository('AcmeSpyBundle:Franchise')->find($franchise_id);
                        else
                            $franchise = false;

                        if (!$franchise) {
                            $json_string = MissionController::utf_cyr(json_encode("Сеть не найдена (".$franchise_id.")"));
                            $response->setStatusCode(404);
                        } else {
                            $entity->setFranchise($franchise);

                            $editForm = $this->createForm(new PointType(), $entity);
                            $data = $request->request->all();
                            unset($data['point']['franchise']);
                            $editForm->bind($data['point']);

                            if ($editForm->isValid()) {

                                $em->persist($entity);
                                $em->flush();
                                $json_string = json_encode($entity->getId());

                            } else {
                                
                                $array['errors'] = array();
                                $errors = $this->get('validator')->validate($entity);

                                if(count($errors) == 0){
                                    $errors = $editForm->getErrors();

                                    foreach ($errors as $key => $error) {
                                        $template = $error->getMessageTemplate();
                                        $parameters = $error->getMessageParameters();

                                        foreach($parameters as $var => $value){
                                            $template = str_replace($var, $value, $template);
                                        }

                                        $array['errors'][$key] = $template;
                                    }

                                } else {

                                    foreach ($errors as $error) {
                                        $array['errors'][$error->getPropertyPath()] = $error->getMessage().' ('.$error->getInvalidValue().')';
                                    }

                                }

                                $json_string = MissionController::utf_cyr(json_encode($array));
                                $response->setStatusCode(400);
                            }
                        }

                    } else {
                        $json_string =  MissionController::utf_cyr(json_encode("Неправильно указана сеть"));
                        $response->setStatusCode(404);
                    }              
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
    }*/

    /**
     * Deletes a Point entity.
     *
     * @Route("/point/{id}", name="point_delete")
     * @Method("DELETE")
     */
    /*
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
    }*/

    /**
     * Creates a form to delete a Point entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    /*
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id),array('csrf_protection' => false))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }*/
}
