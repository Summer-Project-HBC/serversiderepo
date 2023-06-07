<?php

namespace App\Entity;

use App\Repository\FollowedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowedRepository::class)]
class Followed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Events::class)]
    #[ORM\JoinColumn(name: "event_id", referencedColumnName: "id")]
    private ?Events $eventId;

    #[ORM\ManyToOne(targetEntity: Login::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?Login $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?Events
    {
        return $this->eventId;
    }

    public function setEventId(?Events $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getUserId(): ?Login
    {
        return $this->userId;
    }

    public function setUserId(?Login $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
