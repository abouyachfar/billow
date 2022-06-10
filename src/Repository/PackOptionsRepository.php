<?php

namespace App\Repository;

use App\Entity\PackOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PackOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackOptions[]    findAll()
 * @method PackOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackOptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackOptions::class);
    }
}
