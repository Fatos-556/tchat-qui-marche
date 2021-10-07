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

        //        -- à revoir todo: ceci doit être traduit en DQL et quand je le fais elle ne marche avec POST de conversation.js : probleme = je retourne un objet qui ne peut pas être converti en int


//      $query = $this->createQueryBuilder("c")
//->select('c.token')
//      ->LeftJoin('conversation', 'b', 'ON','c.token=b.token')
//          ->andwhere("c.id_user ='".$id_current_user."'")
//          ->andWhere("b.id_user ='".$id_user."'")
//      ->getQuery()
//      ->getResult();
//      return $query;


        $rawSql =
            "SELECT c.token
 from      conversation as c

 LEFT JOIN    conversation as cc ON (c.token = cc.token)

      WHERE c.id_user = " . $id_current_user .
            " AND cc.id_user = " . $id_user;
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($rawSql);
        $stmt->execute([]);

        return $stmt->fetch();
    }

    public function findAllIdsUsers()
    {
        $query = $this->createQueryBuilder("c")
            ->select('c.id');

        return $query;

    }

}
