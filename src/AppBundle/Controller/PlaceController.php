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


class PlaceController extends Controller{



    /**
     * @Route("/place/{id}", name="get_place")
     * @Method("Get")
     */
    public function find($id){

        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository('AppBundle:Place')->find($id);

        return $this->json($place->jsonSerialize());

    }

    /**
     * @Route("/places", name="get_plces")
     * @Method("Get")
     *
     */
    public function findAll(){

        $places = $this->getDoctrine()
            ->getRepository('AppBundle:Place')
            ->findAll();

        return $this->json($places);
    }

    /**
     * @Route("/places",name="find_by_list_ids")
     * @Method("Post")
     */
    public function findByListId(Request $request){
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Place');
        $places = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        foreach ($params["placesId"] as $placeId){
            $places[]=$em->find($placeId);
        }

        return $this->json($places);
    }

    /**
     * @Route("/place", name="add_place")
     * @Method("POST")
     */
    public function addPlace(Request $request){

        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $place = new Place();
        $place->setName($params["name"]);
        $place->setLatitude($params["latitude"]);
        $place->setLongitude($params["longitude"]);
        if(isset($params["description"]))
            $place->setDescription($params["description"]);

        if(isset($params["grade"]))
            $place->setgrade($params["grade"]);

        if(isset($params["type"]))
            $place->setType($params["type"]);

        if(isset($params["googleId"]))
            $place->setType($params["googleId"]);

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

        $em = $this->getDoctrine()->getManager();
        $place = $em->find('AppBundle:Place',$id);
        $em->remove($place);
        $em->flush();

        $success['success']="place have been removed";
        return $this->json($success);

    }



    /**
     * @Route("/place", name="update_place")
     * @Method("PUT")
     */
    public function updatePlace(Request $request){
        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $place = new Place();
        $place->setId($params["id"]);
        $place->setName($params["name"]);
        $place->setLatitude($params["latitude"]);
        $place->setLongitude($params["longitude"]);

        if(isset($params["type"]))
            $place->setType($params["type"]);
        if(isset($params["description"]))
            $place->setDescription($params["description"]);
        if(isset($params["grade"]))
            $place->setgrade($params["grade"]);
        if(isset($params["googleId"]))
            $place->setGoogleId($params["googleId"]);


        $em = $this->getDoctrine()->getManager();
        $em->merge($place);
        $em->flush();

        return $this->json($place->jsonSerialize());
    }


    /**
     * @Route("/place/nearest/{latitude}/{longitude}/{distance}",name="nearest_place")
     * @Method("GET")
     */
    public function getNearestPlaces($latitude,$longitude,$distance = 50){

        $distance = $distance*1000;
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:Place')->findByNearestPlaces($latitude,$longitude,$distance)
        );
    }

    /**
     * @Route("/place/name/{name}",name="find_place_by_name")
     * @Method("Get")
     */
    public function getPlaceByName($name){
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:Place')->findByName($name)
        );
    }

    /**
     * @Route("/place/googleId/{googleId}",name="find_place_by_googleId")
     * @Method("Get")
     */
    public function getPlaceByGoogleId($googleId){
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:Place')->findByGoogleId($googleId)
        );
    }

}