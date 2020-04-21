<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Product;
use App\Pagination\Paginator;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Pagination
    public function findLatest(int $page = 1, int $limit): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            // ->setParameter('now', new \DateTime())
        ;

        return (new Paginator($qb))->paginate($page, $limit);
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalProduct()
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as totalProduct')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    // Get Total Price of Products
    public function totalPrice():?int
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(p.price) as totalPrice')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    // Get Unused total Products
    public function getUnusedProducts():?int
    {
        return $this->createQueryBuilder('p')
            ->select('Count(p.id)')
            ->where("p.status = 'broken'")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
