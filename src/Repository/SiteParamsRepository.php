<?php

namespace App\Repository;

use App\Entity\SiteParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SiteParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteParams[]    findAll()
 * @method SiteParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteParamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteParams::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SiteParams $entity, bool $flush = true): void
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
    public function remove(SiteParams $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
