<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 17/02/17
 * Time: 02:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    /**
     * @Route("/user/{id}", name="get_user")
     * @Method("Get")
     */
    public function find($id){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $em->flush();

        return $this->json($user->jsonSerialize());

    }


    /**
     * @Route("/user", name="get_users")
     * @Method("Get")
     *
     */
    public function findAll(){

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);


        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        $jsonContent = $serializer->serialize($users, 'json');

        return $this->json($jsonContent);
    }


    /**
     * @Route("/user", name="add_user")
     * @Method("POST")
     */
    public function addUser(Request $request){

        $params = array();
        $content = $request->getContent();


        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $user = new User();

        $user->setMail($params["mail"]);
        $user->setFirebazeId($params["firebaseId"]);
        $user->setFirtName($params["firstName"]);
        $user->setLastName($params["lastName"]);
        $user->setUsername($params["username"]);
        $user->setBirthDate($params["birthDate"]);


        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->json($user->jsonSerialize());
    }



    /**
     * @Route("/user/{id}", name="delete_user")
     * @Method("DELETE")
     */
    public function deleteUser($id){
        //   echo "im in";

        $em = $this->getDoctrine()->getManager();
        $user = $em->find('AppBundle:User',$id);
        $em->remove($user);
        $em->flush();

        return "heve been removed";

    }


    /**
     * @Route("/user", name="update_user")
     * @Method("PUT")
     */
    public function updateUser(Request $request){

        $params = array();
        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($params["id"]);

        $user->setMail($params["mail"]);
        $user->setFirebazeId($params["firebaseId"]);
        $user->setFirtName($params["firstName"]);
        $user->setLastName($params["lastName"]);
        $user->setUsername($params["username"]);
        $user->setBirthDate($params["birthDate"]);


        $em->flush();

        return $this->json($user->jsonSerialize());
    }

}