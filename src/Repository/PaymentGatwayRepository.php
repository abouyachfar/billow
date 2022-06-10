<?php

namespace App\Repository;

use App\Entity\PaymentGatway;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentGatway|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentGatway|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentGatway[]    findAll()
 * @method PaymentGatway[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentGatwayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentGatway::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PaymentGatway $entity, bool $flush = true): void
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
    public function remove(PaymentGatway $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
