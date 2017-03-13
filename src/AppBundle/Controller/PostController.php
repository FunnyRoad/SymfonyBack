<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 12/03/17
 * Time: 16:13
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class PostController extends Controller
{

    /**
     * @Route("/post/{id}",name="get_post_by_id")
     * @Method("Get")
     */
    public function find($id){
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:Post')->find($id)
        );
    }

    /**
     * @Route("/posts",name="get_all_posts")
     * @Method("Get")
     */
    public function findAll(){
        $em = $this->getDoctrine()->getManager();
        return $this->json(
            $em->getRepository('AppBundle:Post')->findAll()
        );
    }

    /**
     * @Route("/post",name="create_post")
     * @Method("post")
     */
    public function create(Request $request){

        $em = $this->getDoctrine()->getManager();

        $params = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $post = new Post();
        if(isset($params["text"]))
            $post->setText($params["text"]);

        $post->setRoadtrip(
            $em->getRepository('AppBundle:RoadTrip')->find($params["roadtripId"])
        );

        $em->persist($post);
        $em->flush();

        return $this->json($post);

    }

    /**
     * @Route("/post/{post}",name="update_post")
     * @Method("Put")
     */
    public function update(Post $post,Request $request){

        $em = $this->getDoctrine()->getManager();

        $params = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        if(isset($params["text"]))
            $post->setText($params["text"]);

        $post->setRoadtrip(
            $em->getRepository('AppBundle:RoadTrip')->find($params["roadtripId"])
        );

        $em->flush();

        return $this->json($post);

    }

    /**
     * @Route("/post/{post}",name="delete_post")
     * @Method("Delete")
     */
    public function delete(Post $post){
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $success['success']="post have been removed";
        return $this->json($success);
    }
}