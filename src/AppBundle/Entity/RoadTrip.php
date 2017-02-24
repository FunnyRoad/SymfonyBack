<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="road_trip")
 */
class RoadTrip implements \JsonSerializable {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Place", cascade={"persist"})
     */
    private  $places;


    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="roadtrip")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guests;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function __construct()
    {
        $this->places = new ArrayCollection();
        $this->guests = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * @param mixed $guests
     */
    public function setGuests(User $guests)
    {
        $this->guests = $guests;
    }

    public function addGuest(User $guest){
        $this->guests[]=$guest;
        $guest->addRoadtrip($this);
        return $this;
    }

    public function removeGuest(User $guest){
        $this->guests->removeElement($guest);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * @param mixed $places
     */
    public function setPlaces($places)
    {
        $this->places = $places;
    }

    public function addPlace(Place $place){
        $this->places[]=$place;
        return $this;
    }

    public function removePlace(Place $place){
        $this->places->remove($place);
    }

    public function removeAllPlaces(){
        $this->places->clear();
    }

    /**
     * @return string|\Symfony\Component\Serializer\Encoder\scalar
     *
     * Method to jsonify roadTrip entity
     */
    function jsonSerialize()
    {
        return [
            "name"=>$this->name,
            "owner"=>$this->owner,
        ];
    }
}