<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    private $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Property::class);
        $this->logger = $logger; 
    }

    public function search($cities, $bedrooms, $price_min, $price_max, 
        $property_types, $bathrooms, $living_area_min, $living_area_max, 
        $lot_size_min, $lot_size_max, $return_query=false)
    {
        $properties = null;

        try{
            $price_max = floatval($price_max);
            $price_min = floatval($price_min);

            $qb = $this->createQueryBuilder('p')
                    ->andWhere('p.disabledByAdmin = 1')
                    ->andWhere('p.expired != 1');

            // Set conditions
            if (!empty($cities)) {
                $qb->andWhere('p.city in (:cities)');
            }

            if (!empty($bedrooms)) {
                if (strlen($bedrooms)>1) {
                    $qb->andWhere('p.bedrooms >= :bedrooms');
                } else {
                    $qb->andWhere('p.bedrooms = :bedrooms');
                }                
            }

            if (!empty($price_min)) {
                $qb->andWhere('p.price >= :price_min');
            }

            if (!empty($price_max)) {
                if ($price_max == 5000000) {
                    $qb->andWhere('p.price >= :price_max');
                } else {
                    $qb->andWhere('p.price <= :price_max');
                }
            }

            if (!empty($property_types)) {
                $qb->andWhere('p.PropertyType in (:property_types)');
            }

            if (!empty($bathrooms)) {
                if (strlen($bathrooms)>1) {
                    $qb->andWhere('p.bathrooms >= :bathrooms');
                } else {
                    $qb->andWhere('p.bathrooms = :bathrooms');
                }
            }

            if (!empty($living_area_min) && $living_area_min != 'Min') {
                $qb->andWhere('p.living_space >= :living_area_min');
            }

            if (!empty($living_area_max) && $living_area_max != "Max") {
                $qb->andWhere('p.living_space <= :living_area_max');
            }

            if (!empty($lot_size_min) && $lot_size_min != "Min") {
                $qb->andWhere('p.lot_dimensions >= :lot_size_min');
            }

            if (!empty($lot_size_max) && $lot_size_max != "Max") {
                $qb->andWhere('p.lot_dimensions <= :lot_size_max');
            }

            // Set Parameters
            if (!empty($cities)) {
                $qb->setParameter('cities', $cities);
            }
            
            if (!empty($bedrooms)) {
                $qb->setParameter('bedrooms', $bedrooms);
            }

            if (!empty($price_min)) {
                $qb->setParameter('price_min', $price_min);
            }

            if (!empty($price_max)) {
                $qb->setParameter('price_max', $price_max);
            }
            
            if (!empty($property_types)) {
                $qb->setParameter('property_types', $property_types);
            }
            
            if (!empty($bathrooms)) {
                $qb->setParameter('bathrooms', $bathrooms);
            }

            if (!empty($living_area_min) && $living_area_min != 'Min') {
                $qb->setParameter('living_area_min', $living_area_min);
            }

            if (!empty($living_area_max) && $living_area_max != 'Max') {
                $qb->setParameter('living_area_max', $living_area_max);
            }

            if (!empty($lot_size_min) && $lot_size_min != "Min") {
                $qb->setParameter('lot_size_min', $lot_size_min);
            }

            if (!empty($lot_size_max) && $lot_size_max != "Max") {
                $qb->setParameter('lot_size_max', $lot_size_max);
            }
                       
            $qb->andWhere("p.is_online = 1");

            $properties = $qb->orderBy('p.id', 'DESC')
                            ->getQuery();
        }catch(Exception $ex){
            $this->logger->error("[property_repository] - " . $ex->getMessage());
        }
        
        if ($return_query) {
            return $properties;
        } else {
            return $properties->getResult();
        }
    }

    public function getByOwner($user_id, $return_query=false) {
        $properties = $this->createQueryBuilder('p')
              ->andWhere('p.owner = :user_id')
              ->setParameter('user_id', $user_id)
              ->orderBy('p.id', 'DESC')
              ->getQuery();

        if ($return_query) {
            return $properties;
        } else {
            return $properties->getResult();
        }
    }

    public function getFeaturedHomes($isFeaturedHomes=1, $owner="", $property="", 
        $city="", $return_query=false) 
    {
        $properties = null;

        try{
            $q = $this->createQueryBuilder('p')
                    ->andWhere('p.disabledByAdmin != 1')
                    ->andWhere('p.expired != 1');

            $q->andWhere('p.isFeatured = :isFeaturedHomes')
                ->setParameter('isFeaturedHomes', $isFeaturedHomes);

            if (!empty($owner)) {
                $q->innerJoin('p.owner', 'user', 'WITH', "user.first_name like '%" . $owner . "%' or user.last_name like '%" . $owner . "%'");
            }

            if (!empty($property)) {
                $q->andWhere('p.title like :property')
                    ->setParameter('property', '%' . $property . '%');
            }

            if (!empty($city)) {
                $q->innerJoin('p.city', 'city', 'WITH', "city.label like '%" . $city . "%'");
            }

            $properties = $q->orderBy('p.id', 'DESC')
                            ->getQuery();

            if ($return_query) {
                return $properties;
            } else {
                return $properties->getResult();
            }
        } catch (Exception $ex) {
            $this->logger->error("[property_repository] - " . $ex->getMessage());
        }

        return $properties;
    }

    public function getByAddress($text) {
        $properties = null;

        try{
            $q = $this->createQueryBuilder('p')
                    ->andWhere('p.disabledByAdmin = 1')
                    ->andWhere('p.expired != 1');

            $q->andWhere('p.street like :text')
            ->setParameter('text', '%' . $text . '%');

            $properties = $q->orderBy('p.id', 'DESC')
                            ->getQuery()
                            ->getResult();
        } catch (Exception $ex) {
            $this->logger->error("[property_repository] - " . $ex->getMessage());
        }

        return $properties;
    }
}
