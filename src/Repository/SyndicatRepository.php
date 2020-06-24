<?php

namespace App\Repository;

use App\Entity\Syndicat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Syndicat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Syndicat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Syndicat[]    findAll()
 * @method Syndicat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyndicatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Syndicat::class);
    }

    // /**
    //  * @return Syndicat[] Returns an array of Syndicat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Syndicat
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
