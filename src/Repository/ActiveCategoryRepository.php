<?php

namespace App\Repository;

use App\Entity\ActiveCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActiveCategory>
 *
 * @method ActiveCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActiveCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActiveCategory[]    findAll()
 * @method ActiveCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiveCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActiveCategory::class);
    }

    /**
     * @return ActiveCategory[] Returns an array of ActiveCategory objects
     */
    public function findids($store): array
    {
        $result = $this->createQueryBuilder('a')
            ->innerJoin('a.category', 'category')
            ->select('category.id')
            ->andWhere('a.store = :store')
            ->setParameter('store', $store)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getArrayResult();

        return array_map(function ($r) {
            return $r['id'];
        }, $result);
    }

    /**
     * @return ActiveCategory[] Returns an array of ActiveCategory objects
     */
    public function findMenu($store): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.store', 'store')
            ->innerJoin('a.category', 'category')
            ->innerJoin('category.products', 'products')
            ->select('a, category, products')
            ->andWhere('store = :store')
            ->andWhere('products.owner = :store')
            ->setParameter('store', $store)
            ->orderBy('a.rowOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return ActiveCategory[] Returns an array of ActiveCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ActiveCategory
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
