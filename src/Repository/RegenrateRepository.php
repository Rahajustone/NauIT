<?php

namespace App\Repository;

use App\Entity\Regenrate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Regenrate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regenrate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regenrate[]    findAll()
 * @method Regenrate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegenrateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regenrate::class);
    }

    // /**
    //  * @return Regenrate[] Returns an array of Regenrate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Regenrate
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
