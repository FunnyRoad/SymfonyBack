<?php
/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 02/03/17
 * Time: 15:44
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="departure")
 */
class Departure implements \JsonSerializable
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="float",nullable=false)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float",nullable=false)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string",length=50,nullable=true)
     */
    private $googleId;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\RoadTrip",mappedBy="departure")
     */
    private $roadtrip;

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
            "googleId"=>$this->googleId,
            "latitude"=>$this->latitude,
            "longitude"=>$this->longitude
        ];
    }
}