<?php

/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 03/03/17
 * Time: 15:56
 */
namespace AppBundle\Repository;

use \Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class PlaceRepository extends EntityRepository
{
    /*
    * Fonction qui va permettre de récupérer les places par rapport à leur position
    * Elle prend trois attributs:
    * $latitude: Latitude du point de référence
    * $longitude: Longitude du point de référence
    * $distance: définit la distance maximale entre le point de référence et la place
    */
    public function findByNearestPlaces($longitude,$latitude,$distance){
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Place', 'p');
        $rsm->addFieldResult('p', 'id', 'id'); // ($alias, $columnName, $fieldName)
        $rsm->addFieldResult('p', 'name', 'name');
        $rsm->addFieldResult('p', 'latitude', 'latitude');
        $rsm->addFieldResult('p', 'longitude', 'longitude');
        $rsm->addFieldResult('p', 'description', 'description');
        $rsm->addFieldResult('p', 'grade', 'grade');
        $rsm->addFieldResult('p', 'type', 'type');

        $query = $this->getEntityManager()->createNativeQuery('
              SELECT DISTINCT *, 
              acos((cos(:latitude/(180/3.14169))*cos(:longitude/(180/3.14169))*cos(latitude/(180/3.14169))*cos(longitude/(180/3.14169)))
              + (cos(:latitude/(180/3.14169))*sin(:longitude/(180/3.14169))*cos(latitude/(180/3.14169))*sin(longitude/(180/3.14169))) 
              + (sin(:latitude/(180/3.14169))*sin(latitude/(180/3.14169))))
              *6366000 
            as distance 
            FROM place 
            HAVING distance <= :distance 
        ',$rsm);

        $query->setParameter("latitude",$latitude);
        $query->setParameter("longitude",$longitude);
        $query->setParameter("distance",$distance);

        return $query->getResult();
    }

}