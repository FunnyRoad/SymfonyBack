<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 03/03/17
 * Time: 23:29
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FollowerResource extends Controller
{

    /**
     * @Route("/follower/{userId}/roadtrip/{roadtripId}",name="add_follower_to_roadtrip")
     * @Method("Put")
     */
    public function addFollowerToRoadTrip($userId,$roadtripId){
        $em = $this->getDoctrine()->getManager();
        $follower = $em->getRepository('AppBundle:User')->find($userId);
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $roadtrip->addFollower($follower);
        $em->persist($roadtrip);
        $em->persist($follower);
        $em->flush();

        $success['success'] = "Follower have been added";
        return $this->json($success);
    }

    /**
     * @Route("/follower/{userId}/roadtrips", name="get_followed_roadtrips")
     * @Method("Get")
     */
    public function findFollowedRoadtrips($userId){

        $em = $this->getDoctrine()->getManager();
        $follower = $em->getRepository('AppBundle:User')->find($userId);

        return $this->json($follower->getFollowed());
    }

    /**
     * @Route("/roadtrip/{roadtripId}/followers", name="get_roadtrip_followers")
     * @Method("Get")
     */
    public function findRoadtripFollowers($roadtripId){

        $em = $this->getDoctrine()->getManager();
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);

        return $this->json($roadtrip->getFollowers());
    }


    /**
     * @Route("/follower/{userId}/roadtrip/{roadtripId}",name="remove_roadtip_follower")
     * @Method("Delete")
     */
    public function removeRoadtripFollower($userId,$roadtripId){
        $em = $this->getDoctrine()->getManager();
        $follower = $em->getRepository('AppBundle:User')->find($userId);
        $roadtrip = $em->getRepository('AppBundle:RoadTrip')->find($roadtripId);
        $follower->removeFollowed($roadtrip);
        $roadtrip->removeFollower($follower);
        $em->flush();

        $success['success'] = "Follower have been removed";
        return $this->json($success);
    }

}