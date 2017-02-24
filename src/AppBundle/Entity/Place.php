<?php
// src/AppBundle/Entity/Place.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="string", length=250,nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $grade;


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
            "name"=>$this->name,
            "description"=>$this->description,
            "grade"=>$this->grade
        ];
    }
}