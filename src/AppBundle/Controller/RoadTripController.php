<?php

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Entity\Place;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\RoadTrip;


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RoadTripController extends Controller
{
    /**
     * @Route("/roadtrip/{id}", name="get_roadtrip")
     * @Method("Get")
     */
    public function find($id){

        $em = $this->getDoctrine()->getManager();

        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($id);
        $em->flush();

        return $this->json($roadTrip->jsonSerialize());
    }

    /**
     * @Route("/roadtrip", name="get_roadtrips")
     * @Method("Get")
     *
     */
    public function findAll(){
          $encoders = array(new XmlEncoder(), new JsonEncoder());
          $normalizers = array(new ObjectNormalizer());
          $serializer = new Serializer($normalizers, $encoders);

          $places = $this->getDoctrine()
              ->getRepository('AppBundle:RoadTrip')
              ->findAll();

          $jsonContent = $serializer->serialize($places, 'json');

          return $this->json($jsonContent);
    }


    /**
     * @Route("/roadtrip", name="add_roadtrip")
     * @Method("POST")
     */
    public function addRoadTrip(Request $request){

        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $roadTrip = new RoadTrip();
        $roadTrip->setName($params["name"]);

        $em = $this->getDoctrine()->getManager();
        foreach ($params["place"] as $placeId){
            $roadTrip->addPlace( $em->find('AppBundle:Place',$placeId));
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($roadTrip);
        $em->flush();

        return $this->json($roadTrip->jsonSerialize());
    }

    /**
     * @Route("/roadtrip/{id}/places", name="get_roadtrip_places")
     * @Method("Get")
     */
    public function getRoadtripPlaces($id)
    {
        $em = $this->getDoctrine()->getManager();

        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($id);
        $em->flush();


        $places =  array();
        foreach ($roadTrip->getPlaces() as $placeData){
            $places[] = $placeData->jsonSerialize();
        }

        return $this->json($places);
    }


    /**
     * @Route("/roadtrip/{roadtripId}/place/{placeId}", name="delete_roadtip")
     * @Method("DELETE")
     */
    public function deleteRoadTripPlace($roadtripId,$placeId){

        $em = $this->getDoctrine()->getManager();
        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $place = $em->getRepository("AppBundle:Place")->find($placeId);

        $roadTrip->removePlace($place);

        $em->flush();

        return "Place heve been removed from roadTrip";

    }


    /**
     * @Route("/roadtrip/{id}", name="delete_roadtip")
     * @Method("DELETE")
     */
    public function deleteRoadTrip($id){

        $em = $this->getDoctrine()->getManager();
        $roadTrip = $em->find('AppBundle:RoadTrip',$id);
        $em->remove($roadTrip);
        $em->flush();

        return "heve been removed";

    }



    /**
     * @Route("/roadtrip", name="update_roadtrip")
     * @Method("PUT")
     */
    public function updateRoadtrip(Request $request){
        //   echo "im in";

        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $em = $this->getDoctrine()->getManager();
        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($params["id"]);

        $roadTrip->setName($params["name"]);
        if(isset($params["places"])){
            $roadTrip->removeAllPlaces();
            foreach ($params["place"] as $placeId){
                $roadTrip->addPlace( $em->find('AppBundle:Place',$placeId));
            }
        }

        $em->persist($roadTrip);
        $em->flush();

        return $this->json($roadTrip->jsonSerialize());
    }
}
