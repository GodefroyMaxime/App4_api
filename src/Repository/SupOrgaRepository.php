<?php

namespace App\Repository;

use App\Entity\SupOrga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SupOrga>
 *
 * @method SupOrga|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupOrga|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupOrga[]    findAll()
 * @method SupOrga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupOrgaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupOrga::class);
    }

    //    /**
    //     * @return SupOrga[] Returns an array of SupOrga objects
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

    //    public function findOneBySomeField($value): ?SupOrga
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
