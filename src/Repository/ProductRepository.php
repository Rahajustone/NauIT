<?php

namespace App\Repository;

use App\Entity\Product;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\NonUniqueResultException;

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
    public function findLatest(int $page = 1, int $limit, int $protypeid=null): Paginator
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
        ;

        if($protypeid) {
            $qb->where('p.modelType = :protypeid')->setParameter('protypeid', $protypeid);
        }

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


    public function search($productsId, $devicetypes, $productModels, $users, $ipAddress, $minPrice, $maxPrice, $serialNumber)
    {
        try {

            $sql = "SELECT DISTINCT p.name, p.mac_address, p.ip_address, p.os, p.price, p.created_at, p.updated_at, p.comments, p.status, p.serial_number,  au.full_name, pm.name as pm_name, pt.name as pt_name from product p 
            LEFT JOIN user au on p.assign_to_user_id =  au.id
            LEFT JOIN product_model pm on p.product_model_id =  pm.id
            LEFT JOIN product_type pt on p.model_type_id = pt.id WHERE p.id > 0 ";

            if($productsId) {
                $productsLists = "('".implode("','", $productsId)."')";
                $sql .= " AND p.id IN $productsLists";
            }

            if ($devicetypes) {
                $devicetypesList = "('".implode("','", $devicetypes)."')";
                $sql .= " AND p.model_type_id IN $devicetypesList";
            }

            if ($productModels) {
                $productModelsList = "('".implode("','", $productModels)."')";
                $sql .= " AND pm.id IN $productModelsList";
            }

            if ($users) {
                $userLists = "('".implode("','", $users)."')";
                $sql .= " AND p.assign_to_user_id IN $userLists";
            }

            if($ipAddress) {
                $sql .= " AND p.ip_address LIKE %$ipAddress%";
            }

            if ($minPrice > 0) {
                $sql .= " AND p.price > $minPrice";
            }

            if ($maxPrice > 0) {
                $sql .= " AND p.price > $maxPrice";
            }

            if($serialNumber) {
                $sql .= " AND p.serial_number > $serialNumber";
            }
       
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        } catch (DBALException $e) {
        
        }

        $stmt->execute();
        return $stmt->fetchAll();
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
