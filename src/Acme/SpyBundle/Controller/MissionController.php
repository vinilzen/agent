<?php

namespace Acme\SpyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\SpyBundle\Entity\Mission;
use Acme\SpyBundle\Form\MissionType;

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
     * @Route("/", name="mission",requirements={"_method" = "GET", "_format" = "json"}, defaults={"_format" = "json"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeSpyBundle:Mission')->findAll();

        foreach ($entities as $entity) {
            $entities_array[$entity->getId()]= array(
                'id' => $entity->getId(),
                'runtime' => $entity->getRuntime()->format('Y-m-d H:i:s'),
                'needBuy' => (int)$entity->getNeedBuy(),
                'costs' => (int)$entity->getCosts(),
                'icons' => (string)$entity->getIcons(),
                'form' => (string)$entity->getForm(),
                'description' => (string)(string)$entity->getDescription(),
                'missionType' => $entity->getMissionType()!=NULL?$entity->getMissionType()->getId():0,
                'point' => $entity->getPoint()!=NULL?$entity->getPoint()->getId():0
            );
        }

        $response = new Response();
        $json_string = json_encode(array('data' => $entities_array, 'code' => 200));

$arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
'\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
'\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
'\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
'\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
'\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
'\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
'\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');

$arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');

        $json_string = str_replace($arr_replace_utf,$arr_replace_cyr,$json_string);

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

        //$response->send();
    
        /*
        // return json with clear cache  
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");// HTTP/1.0

        return $this->render('AcmeSpyBundle::API.json.twig', array('result' => $result));*/

        return $response;
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

            $response = new Response();
            $json_string = json_encode(array('data' => $entity->getId(), 'code' => 200));
        } else {
            $json_string = json_encode(array('data' => 'Неверный запрос', 'code' => 400));
        }

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

        $points = $this->getDoctrine()->getManager()->getRepository('AcmeSpyBundle:Point')->findAll();

        //foreach ($points as $point) {            var_dump($point->getTitle());        }

        return array(
            'points' => $points,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mission entity.
     *
     * @Route("/{id}", name="mission_show",requirements={"_method" = "GET", "_format" = "json"}, defaults={"_format" = "json"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSpyBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        } else {
            $entity_array = array(
                'id' => $entity->getId(),
                'runtime' => $entity->getRuntime()->format('Y-m-d H:i:s'),
                'needBuy' => (int)$entity->getNeedBuy(),
                'costs' => (int)$entity->getCosts(),
                'icons' => (string)$entity->getIcons(),
                'form' => (string)$entity->getForm(),
                'description' => (string)(string)$entity->getDescription(),
                'missionType' => $entity->getMissionType()!=NULL?$entity->getMissionType()->getId():0,
                'point' => $entity->getPoint()!=NULL?$entity->getPoint()->getId():0
            );
        }
        $response = new Response();
        $json_string = json_encode(array('data' => $entity_array, 'code' => 200));

        $arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
        '\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
        '\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
        '\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
        '\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
        '\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
        '\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
        '\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');

        $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
        'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
        'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
        'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');

        $json_string = str_replace($arr_replace_utf,$arr_replace_cyr,$json_string);

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

            $response = new Response();
            $json_string = json_encode(array('data' => $entity->getId(), 'code' => 200));
        } else {
            $json_string = json_encode(array('data' => 'Неверный запрос', 'code' => 400));
        }

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

            $response = new Response();
            $json_string = json_encode(array('data' => $id, 'code' => 200));
        } else {
            $json_string = json_encode(array('data' => 'Неверный запрос', 'code' => 400));
        }

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
