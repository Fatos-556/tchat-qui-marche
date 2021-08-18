<?php

namespace App\Repository;

use App\Entity\ConversationMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConversationMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationMessage[]    findAll()
 * @method ConversationMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationMessageRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, ConversationMessage::class);
  }

  public function getAllMessagesByToken($token)
  {
    $rawSql =
      "SELECT m.* from conversation_message as m 
      WHERE m.token = '" .
      $token .
      "' ORDER BY m.id";

    $stmt = $this->getEntityManager()
      ->getConnection()
      ->prepare($rawSql);
    $stmt->execute([]);
    return $stmt->fetchAll();
  }

  public function checkNotification($id_user, $token)
  {
    $rawSql =
      "SELECT MAX(id) as id from conversation_message 
      WHERE see_add IS null AND id_user != ".$id_user." AND token = '".$token."'";
    $stmt = $this->getEntityManager()
      ->getConnection()
      ->prepare($rawSql);
    $stmt->execute([]);
    return $stmt->fetch();
  }

  public function getIdMessageNoSee($id_user, $token)
  {
    $rawSql =
      "SELECT id as id from conversation_message 
      WHERE id_user != ".$id_user." AND token = '".$token."' AND see_add = ''";
    $stmt = $this->getEntityManager()
      ->getConnection()
      ->prepare($rawSql);
    $stmt->execute([]);
    return $stmt->fetch();
  }

  public function updateSeeAdd($id)
  {
    $rawSql = "UPDATE conversation_message
    SET see_add = '1'
    WHERE id=".$id;
    
    $stmt = $this->getEntityManager()
      ->getConnection()
      ->prepare($rawSql);
    return $stmt->execute([]);
  }

  /*
    public function findOneBySomeField($value): ?ConversationMessage
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
