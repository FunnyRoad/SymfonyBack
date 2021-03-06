<?php

namespace AppBundle\Controller;



use AppBundle\Entity\Departure;
use AppBundle\Entity\Post;
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
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $place = $em->getRepository('AppBundle:Place')->find($placeId);
        $roadtrip->addPlace($place);
        $em->flush();
        return $this->json($roadtrip);
    }


    /**
     * @Route("/roadtrip/{roadtripId}/place/{placeId}", name="delete_place_from_roadtip")
     * @Method("DELETE")
     */
    public function deleteRoadTripPlace($roadtripId,$placeId){

        $em = $this->getDoctrine()->getManager();
        $roadTrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $place = $em->getRepository("AppBundle:Place")->find($placeId);

        $roadTrip->removePlace($place);

        $em->flush();


        $success['success']="Place have been removed from roadtrip";
        return $this->json($success);

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

        $success['success']="roadtrip have been removed";
        return $this->json($success);

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
        $roadTrip->setArrival($params["arrival"]);

        $departureData = $params["departure"];

        $departure = new Departure();
        $departure->setLatitude($departureData["latitude"]);
        $departure->setLongitude($departureData["longitude"]);
        if(isset($departureData["googleId"]))
            $departure->setGoogleId($departureData["googleId"]);
        $roadTrip->setDeparture($departure);

        if(isset($params["places"])){
            $roadTrip->removeAllPlaces();
            foreach ($params["places"] as $placeId){
                $roadTrip->addPlace( $em->find('AppBundle:Place',$placeId));
            }
        }

        $em->persist($roadTrip);
        $em->flush();

        return $this->json($roadTrip->jsonSerialize());
    }

    /**
     * @Route("/roadtrip/{roadtripId}/place/{placeId}", name="update_roadtrip_places")
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
     * @Route("/roadtrip/user/{userId}/nearest/{latitude}/{longitude}/{distance}",name="nearest_roadtrips")
     * @Method("GET")
     */
    public function getNearestsRoadtrips($userId,$latitude,$longitude,$distance = 50){

        $distance = $distance*1000;
        $em = $this->getDoctrine()->getManager();
        $nearestRoadtrips = $em->getRepository('AppBundle:RoadTrip')->findByNearestRoadtripsDeparture($latitude,$longitude,$distance);
        $recommandedRoadtrips = array();

        foreach ($nearestRoadtrips as $nearestRoadtrip){
            if(!$this->isAFollowedRoadtrip($nearestRoadtrip,$userId))
                $recommandedRoadtrips[]=$nearestRoadtrip;
        }

        return $this->json(
            $recommandedRoadtrips
        );
    }


    /*
     * FIXME
     * Solution temporaire pour vérifier qu'uon ne recommande pas un roadtrip déjà suivi
     */
    private function isAFollowedRoadtrip(RoadTrip $roadTrip,$userId){
        foreach ($roadTrip->getFollowers() as $follower){
            if($follower->getId() == $userId){
                echo "Je renvoie vrai $userId ".$follower->getId();
                return true;
            }
        }
        return false;
    }


   /**
     * @Route("/roadtrip/{roadtrip}/posts",name="get_roadtrip_posts")
     * @Method("get")
     */
    public function getRoadtripPosts(RoadTrip $roadtrip){
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:Post')->findByRoadtrip($roadtrip)
        );
    }
}
