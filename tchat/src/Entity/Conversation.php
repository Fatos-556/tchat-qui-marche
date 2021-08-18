<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $token;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $date_add;

  /**
   * @ORM\Column(type="integer")
   */
  private $id_user;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getToken(): ?string
  {
    return $this->token;
  }

  public function setToken(?string $token): self
  {
    $this->token = $token;

    return $this;
  }

  public function getDateAdd(): ?string
  {
    return $this->date_add;
  }

  public function setDateAdd(string $date_add): self
  {
    $this->date_add = $date_add;

    return $this;
  }

  public function setIdUser(int $id_user): self
  {
    $this->id_user = $id_user;

    return $this;
  }
  public function getIdUser(): ?int
  {
    return $this->id_user;
  }
}
