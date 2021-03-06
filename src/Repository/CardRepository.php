<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Card::class);
    }

    // /**
    //  * @return Card[] Returns an array of Card objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('c.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?Card
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
    public function getMemberSyandicate($adherent) {

        $q = $this->getEntityManager()->createQuery(
                        "SELECT count(c.id)
	          FROM  App:Card c
                  WHERE c.adherent = :adherent AND (c.year = YEAR(NOW()) OR c.year = YEAR(NOW())-1 OR c.year = YEAR(NOW())-2 )"
                )->setParameter('adherent', $adherent);
        return $q->getSingleScalarResult();
        // resultat vrai 3
    }

    public function getElecter($adherent) {

        $q = $this->getEntityManager()->createQuery(
                        "SELECT count(c.id)
	          FROM  App:Card c
                  WHERE c.adherent = :adherent AND c.year = YEAR(NOW())"
                )->setParameter('adherent', $adherent);
        return $q->getSingleScalarResult();
        // resulat vari 1
    }

    public function getLastCard($adherent) {

        $q = $this->getEntityManager()->createQuery(
                        "SELECT c
	          FROM  App:Card c
                  WHERE c.adherent = :adherent AND c.year = YEAR(NOW())"
                )->setParameter('adherent', $adherent);
        return $q->getResult();
    }

    public function getListMembersSyndicates() {

        $q = $this->getEntityManager()->createQuery(
                "SELECT a
	          FROM  App:Adherent a JOIN App:Card c WITH c.adherent = a.id
                  WHERE c.year = YEAR(NOW()) OR c.year = YEAR(NOW())-1 OR c.year = YEAR(NOW())-2"
        );
        return $q->getResult();
    }

}
