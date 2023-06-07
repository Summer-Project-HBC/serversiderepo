<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Contracts\EventDispatcher\Event;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
class Feedback
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

    #[ORM\Column(length: 10000)]
    private ?string $feedback = null;

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

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(string $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }
}
