<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Category[] Returns an array of Category objects
     */
    public function findCategories(User $user = null, string $type = "default"): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.categoryInStores', 'category_in_store')
            ->select('c')
            ->andWhere('c.type = :type')
            ->andwhere('category_in_store.store = :storeId')
            ->setParameter('type', $type)
            ->setParameter('storeId', $user->getStore()->getId())
            ->orderBy('category_in_store.rowOrder', 'ASC')
//        return $this->getEntityManager()->createQuery('SELECT c FROM App\Entity\Category c WHERE c.owner = :user')
//            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
//
//    public function findAvailableCategories(User $user = null): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.type = :default')
//            ->setParameter('default', 'default')
//            ->orWhere('c.type = :custom')
//            ->setParameter('custom', 'custom')
//            ->andWhere('c.owner = :user')
//            ->setParameter('user', $user)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult();
//
//
//    }

//
//    /**
//     * @return Category[] Returns an array of Category objects
//     */
//    public function findWithProducts(): array
//    {
//        return $this->createQueryBuilder('c')
//            ->leftJoin('c.products', 'products')
//            ->orderBy('c.id', 'ASC')
//            ->getQuery()
//            ->getResult();
//    }

//
//    /**
//         * @return Category[] Returns an array of Category objects
//         */
//        public function findByExampleField($value): array
//        {
//            return $this->createQueryBuilder('c')
//                ->andWhere('c.exampleField = :val')
//                ->setParameter('val', $value)
//                ->orderBy('c.id', 'ASC')
//                ->setMaxResults(10)
//                ->getQuery()
//                ->getResult()
//            ;
//        }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
