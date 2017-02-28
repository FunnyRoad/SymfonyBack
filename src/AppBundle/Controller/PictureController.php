<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 26/02/17
 * Time: 16:08
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Picture;
use AppBundle\Entity\Place;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

use SplFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PictureController extends Controller
{


    /**
     * @Route("/place/{placeId}/picture",name="add_picture_to_place")
     * @Method("POST")
     */
    public function addPictureToPlace(Request $request,$placeId){
        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository('AppBundle:Place')->find($placeId);

        $test = $request->files;

        $file = $test->get("picture");

        $picture = new Picture();
        $picture->setType($file->guessExtension());
        $em->persist($picture);
        $em->flush();

        $place->addPicture($picture);


        $fileName = $picture->getId().'.'.$picture->getType();

        $file->move(
            $this->getParameter('pictures_directory'),
            $fileName
        );

        $em->flush();


        return $this->json($picture);
    }

    /**
     * @Route("/place/{place}/pictures",name="list_of_pictures_id")
     * @Method("Get")
     */
    public function getPicturesOfPlace(Place $place){

        $em = $this->getDoctrine()->getManager();
        $pictures = $em->getRepository('AppBundle:Picture')
            ->findByPlace($place);
        return $this->json($pictures);
    }

    /**
         * @Route("Get",name="get_picture")
     * @Method("GET")
     */
    public function getPicture(Picture $picture){

        $file = new SplFileInfo( $this->getParameter('pictures_directory').'/'.$picture->getId().".".$picture->getType());
        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }


    /**
     * @Route("/picture/{picture}",name="delete_picture")
     * @Method("DELETE")
     */
    public function deletePicture(Picture $picture){
        $em = $this->getDoctrine()->getManager();
        $place = $picture->getPlace();

        $picture->getPlace()->removePicture($picture);
        $em->remove($picture);
        $em->flush();

        return $this->json($place->getPictures());
    }
}