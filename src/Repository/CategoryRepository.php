<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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


    public function findMenu(): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.products', 'products')
            ->innerJoin('products.allergens', 'allergens')
            ->select('c, products, allergens')
            ->andWhere('c.isActive = :isActive')
            ->setParameter('isActive', true)
            ->orderBy('c.rowOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }




    public function save(Category $category, bool $flush = false): void
    {
        
      $this->_em->persist($category);
      if ($flush)
        $this->_em->flush();    
    }

    public function remove(Category $category, bool $flush = false): void
    {
      $this->_em->remove($category);
      if ($flush) 
        $this->_em->flush();
    
    }
}

