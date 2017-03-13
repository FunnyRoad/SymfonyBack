<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 07/03/17
 * Time: 13:15
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post implements \JsonSerializable
{


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="string",nullable=true,length=256)
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Picture",mappedBy="post")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\RoadTrip")
     * @ORM\JoinColumn(nullable=false)
     */
    private $roadtrip;


    /**
     * @return mixed
     */
    public function getRoadtrip()
    {
        return $this->roadtrip;
    }

    /**
     * @param mixed $roadtrip
     */
    public function setRoadtrip($roadtrip)
    {
        $this->roadtrip = $roadtrip;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param mixed $pictures
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
    }

    public function addPicture(Picture $picture){
        $this->pictures[]=$picture;
        $picture->setPost($this);
        return $this;
    }

    public function removePicture(Picture $picture){
        $this->pictures->removeElement($picture);
    }

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
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
        $pictures = array();
        foreach ($this->getPictures() as $picture){
            $pictures[]= $picture->getId();
        }
        return [
            "id"=>$this->id,
            "text"=>$this->text,
            "roadtripId"=>$this->roadtrip->getId(),
            "picturesId"=>$pictures
        ];

    }
}