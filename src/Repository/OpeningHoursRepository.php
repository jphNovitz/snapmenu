<?php

namespace App\Repository;

use App\Entity\OpeningHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OpeningHours>
 */
class OpeningHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpeningHours::class);
    }

    //    /**
    //     * @return OpeningHours[] Returns an array of OpeningHours objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OpeningHours
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function save(OpeningHours $openingHours, bool $flush = false): void
    {
        $this->_em->persist($openingHours);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(OpeningHours $openingHours, bool $flush = false): void
    {
        $this->_em->remove($openingHours);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
