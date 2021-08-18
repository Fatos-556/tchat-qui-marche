<?php

namespace App\Entity;

use App\Repository\ConversationMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationMessageRepository::class)
 */
class ConversationMessage
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   */
  private $id_user;

  /**
   * @ORM\Column(type="text")
   */
  private $token;

  /**
   * @ORM\Column(type="text")
   */
  private $message;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $date_add;

  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $see_add;
/**
   * @ORM\Column(type="text", nullable=true)
   */
  public function getId(): ?int
  {
    return $this->id;
  }

  public function getIdUser(): ?int
  {
    return $this->id_user;
  }

  public function getToken(): ?string
  {
    return $this->token;
  }

  public function setIdUser(int $id_user): self
  {
    $this->id_user = $id_user;

    return $this;
  }

  public function setToken(string $token): self
  {
    $this->token = $token;

    return $this;
  }

  public function getMessage(): ?string
  {
    return $this->message;
  }

  public function setMessage(string $message): self
  {
    $this->message = $message;

    return $this;
  }

  public function getDateAdd(): ?self
  {
    return $this->date_add;
  }

  public function setDateAdd(string $date_add): self
  {
    $this->date_add = $date_add;

    return $this;
  }

  public function getSeeDate(): ?string
  {
    return $this->see_date;
  }

  public function setSeeAdd(string $see_date): self
  {
    $this->see_date = $see_date;

    return $this;
  }
}
