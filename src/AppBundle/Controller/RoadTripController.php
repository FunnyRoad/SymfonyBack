<?php

namespace AppBundle\Controller;



use AppBundle\Entity\Departure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\RoadTrip;

use Doctrine\ORM\Query\ResultSetMapping;

class RoadTripController extends Controller
{
    /**
     * @Route("/roadtrip/{id}", name="get_roadtrip")
     * @Method("Get")
     */
    public function find($id){

        $em = $this->getDoctrine()->getManager();

        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($id);

        return $this->json($roadTrip);
    }

    /**
     * @Route("/roadtrips", name="get_roadtrips")
     * @Method("Get")
     *
     */
    public function findAll(){

          $places = $this->getDoctrine()
              ->getRepository('AppBundle:RoadTrip')
              ->findAll();


          return $this->json($places);
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
        $roadTrip->setArrival($params["arrival"]);

        $departureData = $params["departure"];
        $departure = new Departure();
        $departure->setLatitude($departureData["latitude"]);
        $departure->setLongitude($departureData["longitude"]);
        if(isset($departureData["googleId"]))
            $departure->setGoogleId($departureData["googleId"]);

        $roadTrip->setDeparture($departure);

        $em = $this->getDoctrine()->getManager();

        $owner =$em->getRepository('AppBundle:User')->find($params["owner"]);
        $roadTrip->setOwner($owner);

        if(isset($params["places"]))
            foreach ($params["places"] as $placeId){
                $roadTrip->addPlace( $em->getRepository('AppBundle:Place')->find($placeId));
            }
        if(isset($params["guests"]))
            foreach ($params["guests"] as $guestId){
                $roadTrip->addGuest($em->getRepository('AppBundle:User')->find($guestId));
            }

        $em->persist($roadTrip);
        $em->flush();

        return $this->json($roadTrip->jsonSerialize());
    }

    /**
     * @Route("/roadtrip/{id}/places", name="get_roadtrip_places")
     * @Method("Get")
     */
    public function getRoadtripPlaces(RoadTrip $roadTrip)
    {
        $places =  array();
        foreach ($roadTrip->getPlaces() as $placeData){
            $places[] = $placeData->jsonSerialize();
        }
        return $this->json($places);

    }

    /**
     * @Route("/roadtrip/{roadtripId}/place/{placeId}",name="add_place_to_roadtrip")
     * @Method("POST")
     */
    public function addPlaceToRoadtrip($roadtripId,$placeId){

        $em = $this->getDoctrine()->getManager();
        $roadtripId = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $place = $em->getRepository('AppBundle:Place')->find($placeId);
        $roadtripId->addPlace($place);
        $em->flush();
        return $this->json('"response":"place have been added to roadtrip"');
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
        $roadTrip->setDeparture($params["departure"]);
        $roadTrip->setArrival($params["arrival"]);

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

    /**
     * @Route("/roadtrip/{roadtripId}/place/{placeId}", name="update_roadtrip")
     * @Method("PUT")
     */
    public function updateRoadtripAddPlace($roadtripId,$placeId){


        $em = $this->getDoctrine()->getManager();
        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $place = $em->getRepository('AppBundle:Place')->find($placeId);

        $roadTrip->addPlace($place);

        $em->flush();

        return $this->json($roadTrip->jsonSerialize());
    }

    /**
     * @Route("/roadtrip/nearest/{latitude}/{longitude}/{distance}",name="nearest_roadtrips")
     * @Method("GET")
     */
    public function getNearestsRoadtrips($latitude,$longitude,$distance = 50){

        $distance = $distance*1000;
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:RoadTrip')->findByNearestRoadtripsDeparture($latitude,$longitude,$distance)
        );
    }

}
