<?php

namespace App\Repository;

use App\Entity\PropertyTypeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyTypeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyTypeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyTypeCategory[]    findAll()
 * @method PropertyTypeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyTypeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyTypeCategory::class);
    }
}
