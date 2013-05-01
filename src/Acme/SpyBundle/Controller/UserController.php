<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\User;
use Acme\SpyBundle\Controller\MissionController;

/**
 * Point controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeSpyBundle:User')->findAll();

        foreach ($entities as $entity) {
            $entities_array[] = array(
                'id'            =>  $entity->getId(),
                'username'      =>  $entity->getUsername(),
                'email'   		=>  $entity->getEmail(),
                'sex'         	=>  $entity->getSex(),
                'age'   		=>  $entity->getAge(),
                'education'     =>  $entity->getEducation(),
                'income'		=>	$entity->getIncome(),
                'city'			=>	$entity->getCity(),

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
}