<?php

namespace App\Repository;

use App\Entity\LogDatabaseChanges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LogDatabaseChanges|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogDatabaseChanges|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogDatabaseChanges[]    findAll()
 * @method LogDatabaseChanges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogDatabaseChangesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogDatabaseChanges::class);
    }

    // /**
    //  * @return LogDatabaseChanges[] Returns an array of LogDatabaseChanges objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LogDatabaseChanges
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
