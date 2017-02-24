<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 17/02/17
 * Time: 02:29
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements \JsonSerializable
{


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",nullable=false)
     */
    private $firebaseId;

    /**
     * @ORM\Column(type="string",nullable=false,length=50)
     */
    private $mail;

    /**
     * @ORM\Column(type="string",length=40,nullable=true)
     */
    private $firtName;

    /**
     * @ORM\Column(type="string",length=40,nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string",length=40,nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\RoadTrip" , mappedBy="guests")
     */
    private $roadtrips;

    public function __construct(){
        $this->roadtrips=new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getRoadtrips()
    {
        return $this->roadtrips;
    }

    /**
     * @param mixed $roadtrips
     */
    public function setRoadtrips($roadtrips)
    {
        $this->roadtrips = $roadtrips;
    }

    public function addRoadtrip(RoadTrip $roadtrip){
        $this->roadtrips[]=$roadtrip;
        return $this;
    }

    public function removeRoadtrip(RoadTrip $roadtrip){
        $this->roadtrips->removeElement($roadtrip);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getFirtName()
    {
        return $this->firtName;
    }

    /**
     * @param mixed $firtName
     */
    public function setFirtName($firtName)
    {
        $this->firtName = $firtName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getfirebaseId()
    {
        return $this->firebaseId;
    }

    /**
     * @param mixed $firebaseId
     */
    public function setfirebaseId($firebaseId)
    {
        $this->firebaseId = $firebaseId;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }


    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            "id"=>$this->id,
            "firebaseId"=>$this->firebaseId,
            "username"=>$this->username,
            "mail"=>$this->mail,
            "firstnName"=>$this->firtName,
            "lastName"=>$this->lastName,
            "birthDate"=>$this->birthDate
        ];
    }
}