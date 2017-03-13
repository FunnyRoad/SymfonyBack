<?php
// src/AppBundle/Entity/Place.php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 * @ORM\Table(name="place")
 */
class Place implements \JsonSerializable {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=40,nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable= true)
     */
    private $googleId;


    /**
     * @ORM\Column(type="float",nullable=false)
     */
    private $latitude;
    /**
     * @ORM\Column(type="float",nullable=false)
     */
    private $longitude;
    /**
     * @ORM\Column(type="string", length=250,nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $grade;
    /**
     * @ORM\Column(type="string",nullable=false,length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $numberOfVoters;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Picture",mappedBy="place")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pictures;

    /**
     * @return mixed
     */
    public function getNumberOfVoters()
    {
        return $this->numberOfVoters;
    }

    /**
     * @param mixed $numberOfVoters
     */
    public function setNumberOfVoters($numberOfVoters)
    {
        $this->numberOfVoters = $numberOfVoters;
    }



    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param mixed $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }



    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function addPicture(Picture $picture){
        $this->pictures[]=$picture;
        $picture->setPlace($this);
        return $this;
    }

    public function removePicture(Picture $picture){
        $this->pictures->removeElement($picture);
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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Get id
     *
     *  @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Place
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Place
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set grade
     *
     * @param float $grade
     *
     * @return Place
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }
    /**
     * Get grade
     *
     * @return float
     */
    public function getGrade()
    {
        return $this->grade;
    }


    /**
     * @return string|\Symfony\Component\Serializer\Encoder\scalar
     *
     * Method to jsonify Place entity
     */
    function jsonSerialize()
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "description"=>$this->description,
            "grade"=>$this->grade,
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude,
            "numberVoters"=>$this->numberOfVoters
        ];
    }
}