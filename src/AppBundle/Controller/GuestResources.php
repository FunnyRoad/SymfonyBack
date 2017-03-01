<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 22/02/17
 * Time: 20:16
 */

namespace AppBundle\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuestResources extends Controller
{

    /**
     * @Route("test",name="test")
     * @Method("get")
     */
    public function test(){
        
    }

    /**
     * @Route("/guest/{guestId}/roadtrips", name="get_user_roadtrip")
     * @Method("Get")
     */
    public function findRoadTripsOfGuest($guestId){

        $em = $this->getDoctrine()->getManager();
        $guest = $em->getRepository('AppBundle:User')->find($guestId);

        $respone = array();
        foreach ($guest->getRoadtrips() as $roadtrip){
            $respone[] = $roadtrip->jsonSerialize();
        }
        return $this->json($respone);
    }

    /**
     * @Route("/roadtrip/{roadtripId}/guests", name="get_roadtrip_guests")
     * @Method("Get")
     */
    public function findGuestsOfRoadtrip($roadtripId){

        $em = $this->getDoctrine()->getManager();
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);

        $respone = array();
        foreach ($roadtrip->getGuests() as $guest){
            $respone[] = $guest->jsonSerialize();
        }
        return $this->json($respone);
    }


    /**
     * @Route("/guest/{guestId}/roadTrip/{roadtripId}",name="add_guest_to_roadtrip")
     * @Method("Put")
     */
    public function addGuestToRoadTrip($guestId,$roadtripId){
        $em = $this->getDoctrine()->getManager();
        $guest = $em->getRepository('AppBundle:User')->find($guestId);
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $roadtrip->addguest($guest);
        $em->flush();
        return $this->json('"response":"guest have been added"');
    }

    /**
     * @Route("/guest/{guestId}/roadtrip/{roadtripId}",name="remove_roadtip_guest")
     * @Method("Delete")
     */
    public function removeGuestFromRoatrip($guestId,$roadtripId){
        $em = $this->getDoctrine()->getManager();
        $guest = $em->getRepository('AppBundle:User')->find($guestId);
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $roadtrip->removeguest($guest);
        $em->flush();
        return $this->json('"response":"guest have been added"');
    }

}