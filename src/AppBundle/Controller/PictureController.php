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
use AppBundle\Entity\Post;
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
            $this->getParameter('place_pictures_directory'),
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
     * @Route("/picture/{picture}",name="get_picture")
     * @Method("GET")
     */
    public function getPicture(Picture $picture){

        $file = new SplFileInfo( $this->getParameter('place_pictures_directory').'/'.$picture->getId().".".$picture->getType());
        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }


    /**
     * @Route("/post/{postId}/picture",name="add_picture_to_post")
     * @Method("POST")
     */
    public function addPictureToPost(Request $request,$postId){
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($postId);

        $test = $request->files;

        $file = $test->get("picture");

        $picture = new Picture();
        $picture->setType($file->guessExtension());
        $em->persist($picture);
        $em->flush();

        $post->addPicture($picture);


        $fileName = $picture->getId().'.'.$picture->getType();

        $file->move(
            $this->getParameter('roadtrip_pictures_directory'),
            $fileName
        );

        $em->flush();


        return $this->json($picture);
    }

    /**
     * @Route("/post/{post}/pictures",name="list_of_pictures_id_of_post")
     * @Method("Get")
     */
    public function getPicturesOfPost(Post $post){

        $em = $this->getDoctrine()->getManager();
        $pictures = $em->getRepository('AppBundle:Picture')
            ->findByPost($post);
        return $this->json($pictures);

    }

    /**
     * @Route("/post/picture/{picture}",name="get_picture_of_post")
     * @Method("GET")
     */
    public function getPictureOfPost(Picture $picture){

        $file = new SplFileInfo( $this->getParameter('roadtrip_pictures_directory').'/'.$picture->getId().".".$picture->getType());
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

        if($picture->getPlace() != null)
            $picture->getPlace()->removePicture($picture);
        if($picture->getPost() != null)
            $picture->getPost()->removePicture($picture);
        $em->remove($picture);
        $em->flush();

        $success['success'] = "Picture heve been removed";
        return $this->json($success);
    }

}