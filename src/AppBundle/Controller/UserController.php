<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 17/02/17
 * Time: 02:37
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;


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
        if($user === null)return $this->json("\"error\":\"User not found\"");
        return $this->json($user->jsonSerialize());

    }


    /**
     * @Route("/users", name="get_users")
     * @Method("Get")
     *
     */
    public function findAll(){

        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        return $this->json($users);
    }


    /**
     * @Route("/user", name="add_user")
     * @Method("POST")
     */
    public function createUser(Request $request){

        $params = array();

        if($request->getContent() == null)
            return $this->json("\"error\":\"bad request\"");

        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        $user = new User();

        $user->setMail($params["mail"]);

        $user->setfirebaseId($params["firebaseId"]);

        if(isset($params["firstName"]))
            $user->setFirstName($params["firstName"]);

        if(isset($params["lastName"]))
            $user->setLastName($params["lastName"]);

        if(isset($params["username"]))
            $user->setUsername($params["username"]);

        if(isset($params["birthDate"]))
            $user->setBirthDate($params["birthDate"]);
        if(isset($params["city"]))
            $user->setCity($params["city"]);

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


        $success['success'] = "User have been removed ";
        return $this->json($success);

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
        $user->setfirebaseId($params["firebaseId"]);

        if(isset($params["firstName"]))
            $user->setFirstName($params["firstName"]);
        if(isset($params["lastName"]))
            $user->setLastName($params["lastName"]);
        if(isset($params["username"]))
            $user->setUsername($params["username"]);
        if(isset($params["birthDate"]))
            $user->setBirthDate($params["birthDate"]);


        $em->flush();

        return $this->json($user->jsonSerialize());
    }

}