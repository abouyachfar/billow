<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    /**
    * @return City[] Returns an array of City objects
    */
    public function findByKey($key)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.label like :val')
            ->setParameter('val', $key.'%')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return City[] Returns an array of City objects by region
    */
    public function getByRegion($region_id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.region = :region_id')
            ->setParameter('region_id', $region_id)
            ->orderBy('c.label', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
