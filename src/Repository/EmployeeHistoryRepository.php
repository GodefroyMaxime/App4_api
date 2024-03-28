<?php

namespace App\Repository;

use App\Entity\EmployeeHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmployeeHistory>
 *
 * @method EmployeeHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeHistory[]    findAll()
 * @method EmployeeHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeHistory::class);
    }

    //    /**
    //     * @return EmployeeHistory[] Returns an array of EmployeeHistory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EmployeeHistory
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
