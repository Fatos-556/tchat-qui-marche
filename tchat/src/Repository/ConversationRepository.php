<?php

namespace App\Repository;

use App\Entity\Conversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Conversation::class);
  }

  public function getTokenByIdUsers($id_current_user, $id_user)
  {
    $rawSql =
      "SELECT c.token from conversation as c LEFT JOIN conversation as cc ON (c.token = cc.token) 
      WHERE c.id_user = " .
      $id_current_user .
      " AND cc.id_user = " .
      $id_user;
    $stmt = $this->getEntityManager()
      ->getConnection()
      ->prepare($rawSql);
    $stmt->execute([]);

    return $stmt->fetch();
  }

  public function findAllIdsUsers()
  {
    $rawSql =
      "SELECT id from conversation";
     $stmt = $this->getEntityManager()
      ->getConnection()
      ->prepare($rawSql);
    $stmt->execute([]);
    return $stmt->fetchAll();
  }

  // /**
  //  * @return Conversation[] Returns an array of Conversation objects
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
    public function findOneBySomeField($value): ?Conversation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
