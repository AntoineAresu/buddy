<?php

namespace App\Entity;

use App\Repository\NightRepository;
use App\Validator\Constraints as CustomAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NightRepository::class)]
#[CustomAssert\NightDateConsistency]
class Night
{
    final public const int MAX_DURATION_HOURS = 15;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTime $end = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\LessThan(propertyPath: 'end')]
    private ?\DateTime $start = null;

    #[ORM\ManyToOne(inversedBy: 'nights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dog $dog = null;

    public function __construct()
    {
        $this->start = new \DateTime('yesterday')->setTime(22, 0);
        $this->end = new \DateTime('today')->setTime(8, 0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnd(): ?\DateTime
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getDog(): ?Dog
    {
        return $this->dog;
    }

    public function setDog(?Dog $dog): static
    {
        $this->dog = $dog;

        return $this;
    }

    public function getDurationInHours(): float
    {
        return round(
            ($this->end?->getTimestamp() - $this->start?->getTimestamp()) / 3600,
            1
        );
    }
}
