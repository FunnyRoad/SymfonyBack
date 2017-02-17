<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 12/01/17
 * Time: 15:06
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Place;


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PlaceController extends Controller{



    /**
     * @Route("/place/{id}", name="get_place")
     * @Method("Get")
     */
    public function find($id){
        //   echo "im in";

        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository('AppBundle:Place')->find($id);
        $em->flush();
        dump($place->getRoadtrip());
        return $this->json($place->jsonSerialize());

    }


    /**
     * @Route("/place", name="get_plces")
     * @Method("Get")
     *
     */
    public function findAll(){

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);


        $places = $this->getDoctrine()
            ->getRepository('AppBundle:Place')
            ->findAll();

        $jsonContent = $serializer->serialize($places, 'json');

        return $this->json($jsonContent);
    }

    /**
     * @Route("/place", name="add_place")
     * @Method("POST")
     */
    public function addPlace(Request $request){
        //   echo "im in";

        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $place = new Place();
        $place->setDescription($params["description"]);
        $place->setName($params["name"]);
        $place->setgrade($params["grade"]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();

        return $this->json($place->jsonSerialize());
    }

    /**
     * @Route("/place/{id}", name="place")
     * @Method("DELETE")
     */
    public function deletePlace($id){
        //   echo "im in";

        $em = $this->getDoctrine()->getManager();
        $place = $em->find('AppBundle:Place',$id);
        $em->remove($place);
        $em->flush();

        return "heve been removed";

    }



    /**
     * @Route("/place", name="update_place")
     * @Method("PUT")
     */
    public function updatePlace(Request $request){
        //   echo "im in";

        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $place = new Place();
        $place->setId($params["id"]);
        $place->setDescription($params["description"]);
        $place->setName($params["name"]);
        $place->setgrade($params["grade"]);

        $em = $this->getDoctrine()->getManager();
        $em->merge($place);
        $em->flush();

        return $this->json($place->jsonSerialize());
    }
}