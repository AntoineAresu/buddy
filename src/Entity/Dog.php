<?php

namespace App\Entity;

use App\Repository\DogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DogRepository::class)]
class Dog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\DateTime]
    private ?\DateTime $birthDate = null;

    #[ORM\ManyToOne(inversedBy: 'dogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Night>
     */
    #[ORM\OneToMany(targetEntity: Night::class, mappedBy: 'dog', orphanRemoval: true)]
    private Collection $nights;

    /**
     * @var Collection<int, Crossing>
     */
    #[ORM\OneToMany(targetEntity: Crossing::class, mappedBy: 'dog', orphanRemoval: true)]
    private Collection $crossings;

    public function __construct()
    {
        $this->nights = new ArrayCollection();
        $this->crossings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Night>
     */
    public function getNights(): Collection
    {
        return $this->nights;
    }

    public function addNight(Night $night): static
    {
        if (!$this->nights->contains($night)) {
            $this->nights->add($night);
            $night->setDog($this);
        }

        return $this;
    }

    public function removeNight(Night $night): static
    {
        if ($this->nights->removeElement($night)) {
            // set the owning side to null (unless already changed)
            if ($night->getDog() === $this) {
                $night->setDog(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Crossing>
     */
    public function getCrossings(): Collection
    {
        return $this->crossings;
    }

    public function addCrossing(Crossing $crossing): static
    {
        if (!$this->crossings->contains($crossing)) {
            $this->crossings->add($crossing);
            $crossing->setDog($this);
        }

        return $this;
    }

    public function removeCrossing(Crossing $crossing): static
    {
        if ($this->crossings->removeElement($crossing)) {
            // set the owning side to null (unless already changed)
            if ($crossing->getDog() === $this) {
                $crossing->setDog(null);
            }
        }

        return $this;
    }

    private function getTotalSleepInHours(): float
    {
        return array_reduce(
            $this->nights->toArray(),
            fn (float $carry, Night $night) => $carry + $night->getDurationInHours(),
            0.0
        );
    }

    public function getAverageSleep(): float
    {
        return $this->nights->isEmpty()
            ? 0
            : round($this->getTotalSleepInHours() / $this->nights->count(), 1);
    }

    /**
     * @return array<int, array<string, float|string|null>>
     */
    public function getNightsToArray(): array
    {
        return $this->nights->map(fn (Night $night) => [
            'start' => $night->getStart()?->format('Y-m-d H:i:s'),
            'duration' => $night->getDurationInHours(),
            'end' => $night->getEnd()?->format('Y-m-d H:i:s'),
        ])->toArray();
    }
}
