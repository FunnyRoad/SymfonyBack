<?php

namespace AppBundle\Controller;

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
          $roadTrip = $em->find('AppBundle:RoadTrip',$id);
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

}
