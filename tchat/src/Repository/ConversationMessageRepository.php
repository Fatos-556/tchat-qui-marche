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


    public function checkNotification($id_user, $token)
    {
        $query = $this->createQueryBuilder('c')
            ->Where("see_add=null")
            ->Where("id_user != " . $id_user)
            ->AndWhere('token = ' . $token)
            ->getQuery()
            ->getResult();
        return $query;
    }

    public function getIdMessageNoSee($id_user, $token)
    {
        $query = $this->createQueryBuilder('c')
            ->Where("id_user != " . $id_user)
            ->AndWhere('token = ' . $token)
            ->AndWhere("see_add=''")
            ->getQuery()
            ->getResult();
        return $query;


    }

    public function getAllMessagesByToken($token)
    {
//        -- à revoir todo: ceci doit être traduit en DQL et quand je le fais elle ne marche avec POST de conversation.js : probleme = je retourne un objet qui ne peut pas être converti en int
//        $query=$this->createQueryBuilder('c')
//            ->Where("token = ".$token)
//        ->getQuery()
//        ->getResult();
//                return $query;
//
        $rawSql =
            "SELECT m.*
              from conversation_message as m
              WHERE m.token = '" . $token .
            "' ORDER BY m.id";

        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($rawSql);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function updateSeeAdd($id)
    {
        $query = $this->createQueryBuilder("c")
            ->update('c.message')
            ->set('see_add', '1')
            ->where("c.id = " . $id);
        return $query;
    }


}
