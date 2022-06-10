<?php

namespace App\Repository;

use App\Entity\SellPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SellPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SellPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SellPage[]    findAll()
 * @method SellPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SellPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SellPage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SellPage $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(SellPage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
