<?php

namespace App\Repository;

use App\Entity\Favorites;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Favorites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorites[]    findAll()
 * @method Favorites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoritesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorites::class);
    }

    public function exists($property_id, $user) {
        $favorite = $this->createQueryBuilder('f')
                    ->andWhere('f.user = :user_id')
                    ->andWhere('f.property = :property_id')
                    ->setParameter('user_id', $user->getId())
                    ->setParameter('property_id', $property_id)
                    ->getQuery()
                    ->getResult()
                    ;

        if (!empty($favorite)) {
            return true;
        }

        return false;
    }

    public function findByPropertyAndUser($property_id, $user_id) {
        return $this->createQueryBuilder('f')
                    ->andWhere('f.user = :user_id')
                    ->andWhere('f.property = :property_id')
                    ->setParameter('user_id', $user_id)
                    ->setParameter('property_id', $property_id)
                    ->getQuery()
                    ->getOneOrNullResult()
                    ;
    }

    public function findByUser($user_id) {
        $favorites = $this->createQueryBuilder('f')
                    ->andWhere('f.user = :user_id')
                    ->setParameter('user_id', $user_id)
                    ->getQuery()
                    ->getResult();

        return $favorites;
    }
}
