<?php

namespace App\Repository;

use App\Entity\BuyPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuyPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuyPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuyPage[]    findAll()
 * @method BuyPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuyPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuyPage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BuyPage $entity, bool $flush = true): void
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
    public function remove(BuyPage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
