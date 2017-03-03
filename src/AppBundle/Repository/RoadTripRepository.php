<?php

/**
 * Created by PhpStorm.
 * User: nassim
 * Date: 03/03/17
 * Time: 16:14
 */

namespace AppBundle\Repository;
use Doctrine\ORM\Query\ResultSetMapping;
use \Doctrine\ORM\EntityRepository;

class RoadTripRepository extends EntityRepository
{

    /*
     * Fonction qui va permettre de récupérer les roadtrips par rapport à la position de départ
     * Elle prend trois attributs:
     * $latitude: Latitude du point de référence
     * $longitude: Longitude du point de référence
     * $distance: définit la distance maximale entre le point de référence et le roadtrip
     */
    public function findByNearestRoadtripsDeparture($latitude,$longitude,$distance){
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\RoadTrip', 'rt');
        $rsm->addFieldResult('rt', 'id', 'id'); // ($alias, $columnName, $fieldName)
        $rsm->addFieldResult('rt', 'name', 'name');
        $rsm->addFieldResult('rt', 'arrival', 'arrival');

        $query = $this->getEntityManager()->createNativeQuery('
              SELECT DISTINCT rt.id as id, 
              name as name, 
              arrival as arrival,
              departure_id as departure,
              acos((cos(:latitude/(180/3.14169))*cos(:longitude/(180/3.14169))*cos(d.latitude/(180/3.14169))*cos(d.longitude/(180/3.14169)))
              + (cos(:latitude/(180/3.14169))*sin(:longitude/(180/3.14169))*cos(d.latitude/(180/3.14169))*sin(d.longitude/(180/3.14169))) 
              + (sin(:latitude/(180/3.14169))*sin(d.latitude/(180/3.14169))))
              *6366000 
            as distance 
            FROM road_trip rt,departure d 
            where rt.departure_id = d.id
            HAVING distance <= :distance 
        ',$rsm);

        $query->setParameter("latitude",$latitude);
        $query->setParameter("longitude",$longitude);
        $query->setParameter("distance",$distance);
        $results=$query->getResult();

        $roadtrips = array();

        $this->getEntityManager()->clear();

        foreach($results as  $one){
            $roadtrips[] = $this->getEntityManager()
                ->getRepository('AppBundle:RoadTrip')->find($one->getId());
        }
        return $roadtrips;
    }

}