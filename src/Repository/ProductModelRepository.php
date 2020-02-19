<?php

namespace App\Repository;

use App\Entity\ProductModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductModel[]    findAll()
 * @method ProductModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductModel::class);
    }

    // /**
    //  * @return ProductModel[] Returns an array of ProductModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductModel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
