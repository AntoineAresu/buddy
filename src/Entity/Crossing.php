<?php

namespace App\Entity;

use App\Entity\Enum\FreedomLevel;
use App\Entity\Enum\Location;
use App\Entity\Enum\ReactionLevel;
use App\Repository\CrossingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CrossingRepository::class)]
class Crossing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $distance = null;

    #[ORM\Column(enumType: Location::class)]
    #[Assert\NotBlank]
    private ?Location $location = null;

    #[ORM\Column(enumType: FreedomLevel::class)]
    #[Assert\NotBlank]
    private ?FreedomLevel $freedomLevel = null;

    #[ORM\Column(nullable: true, enumType: ReactionLevel::class)]
    private ?ReactionLevel $reaction = null;

    #[ORM\ManyToOne(inversedBy: 'crossings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dog $dog = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTime $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getFreedomLevel(): ?FreedomLevel
    {
        return $this->freedomLevel;
    }

    public function setFreedomLevel(FreedomLevel $freedomLevel): static
    {
        $this->freedomLevel = $freedomLevel;

        return $this;
    }

    public function getReaction(): ?ReactionLevel
    {
        return $this->reaction;
    }

    public function setReaction(?ReactionLevel $reaction): static
    {
        $this->reaction = $reaction;

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

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }
}
