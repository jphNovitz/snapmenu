<?php

namespace App\Repository;

use App\Entity\CategoryInStore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryInStore>
 *
 * @method CategoryInStore|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryInStore|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryInStore[]    findAll()
 * @method CategoryInStore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryInStoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryInStore::class);
    }

    //    /**
    //     * @return CategoryInStore[] Returns an array of CategoryInStore objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CategoryInStore
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
