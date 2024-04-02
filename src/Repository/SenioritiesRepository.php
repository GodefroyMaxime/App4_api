<?php

namespace App\Repository;

use App\Entity\Seniorities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seniorities>
 *
 * @method Seniorities|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seniorities|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seniorities[]    findAll()
 * @method Seniorities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SenioritiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seniorities::class);
    }

    //    /**
    //     * @return Seniorities[] Returns an array of Seniorities objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Seniorities
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
