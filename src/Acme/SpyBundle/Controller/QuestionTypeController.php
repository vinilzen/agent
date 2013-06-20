<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\QuestionType;
use Acme\SpyBundle\Controller\MissionController;
use Acme\SpyBundle\Form\QuestionTypeType;

/**
 * QuestionType controller.
 *
 * @Route("/questiontype")
 */
class QuestionTypeController extends Controller
{
    /**
     * Lists all Question entities.
     *
     * @Route("/", name="question_type")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeSpyBundle:QuestionType')->findAll();

        foreach ($entities as $entity) {
            $entities_array[] = array(
                'id'            =>  $entity->getId(),
                'title'         =>  $entity->getTitle()
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
     * Creates a new QuestionType entity.
     *
     * @Route("/", name="question_type_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $response = new Response();

        $entity  = new QuestionType();
        $form = $this->createForm(new QuestionTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $json_string = json_encode(array('id'=>$entity->getId()));
            $response->setStatusCode(201); // created
        } else {
            $errors = $form->getErrors();
            $json_string = json_encode(serialize($errors));
            $response->setStatusCode(400);
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
     * Displays a form to create a new Question entity.
     *
     * @Route("/new", name="question_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Question();
        $form   = $this->createForm(new QuestionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a QuestionType entity.
     *
     * @Route("/{id}", name="questiontype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSpyBundle:QuestionType')->find($id);

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
            $json_string = json_encode('Такой тип не найден');
            $response->setStatusCode(404);
        } else {
            $entity_array = array(
                'id'            =>  $entity->getId(),
                'title'         =>  $entity->getTitle()
            );

            $json_string = json_encode($entity_array);
        }

        $json_string = MissionController::utf_cyr($json_string);

        $response->setContent($json_string);
        return $response;
    }

    /**
     * Edits an existing QuestionType entity.
     *
     * @Route("/{id}", name="questiontype_update")
     * @Method("PUT")
     * @Template("AcmeSpyBundle:Question:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSpyBundle:QuestionType')->find($id);

        if (!$entity) {
            $json_string = MissionController::utf_cyr(json_encode('Такой тип не найден'));

            $response->setStatusCode(404);
            $response->setContent($json_string);
            
        } else {

            $editForm = $this->createForm(new QuestionTypeType(), $entity);
            $editForm->bind($request);

            if ($editForm->isValid()) {
                $em->persist($entity);
                $em->flush();
                $json_string = json_encode($entity->getId());
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
     * Deletes a Question entity.
     *
     * @Route("/{id}", name="question_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $response = new Response();

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeSpyBundle:QuestionType')->find($id);

            if (!$entity) {
                $json_string = MissionController::utf_cyr(json_encode('Такой тип не найден'));
                $response->setStatusCode(404);
                $response->setContent($json_string);
            } else {
                $em->remove($entity);
                $em->flush();
                $json_string = $id;
            }
        } else {

            $errors = array();
            foreach ($form->getErrors() as $key => $error) {
                $template = $error->getMessageTemplate();
                $parameters = $error->getMessageParameters();
                foreach($parameters as $var => $value){
                    $template = str_replace($var, $value, $template);
                }
                $errors[$key] = $template;
            }

            $json_string = json_encode($errors[0]);
            $response->setStatusCode(400);
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
     * Creates a form to delete a Question entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id), array('csrf_protection' => false))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
