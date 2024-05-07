<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningHoursRepository::class)]
class OpeningHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $dayOfWeek;

    #[ORM\Column(type: "time")]
    private \DateTimeInterface $openTime;

    #[ORM\Column(type: "time")]
    private \DateTimeInterface $closeTime;

    public function __construct(
        string             $dayOfWeek,
        \DateTimeInterface $openTime,
        \DateTimeInterface $closeTime
    )
    {
        $this->dayOfWeek = $dayOfWeek;
        $this->openTime = $openTime;
        $this->closeTime = $closeTime;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(string $dayOfWeek): self
    {
        $this->dayOfWeek = $dayOfWeek;
        return $this;
    }

    public function getOpenTime(): \DateTimeInterface
    {
        return $this->openTime;
    }

    public function setOpenTime(\DateTimeInterface $openTime): self
    {
        $this->openTime = $openTime;
        return $this;
    }

    public function getCloseTime(): \DateTimeInterface
    {
        return $this->closeTime;
    }

    public function setCloseTime(\DateTimeInterface $closeTime): self
    {
        $this->closeTime = $closeTime;
        return $this;
    }
}
