<?php

namespace App\Entity;

use App\Repository\HabitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitRepository::class)]
class Habit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 6)]
    private ?string $color = null;

    #[ORM\ManyToOne(inversedBy: 'habits')]
    private ?HabitCategory $category = null;

    #[ORM\OneToMany(mappedBy: 'habit', targetEntity: HabitRecord::class, orphanRemoval: true)]
    private Collection $habitRecords;

    public function __construct()
    {
        $this->habitRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCategory(): ?HabitCategory
    {
        return $this->category;
    }

    public function setCategory(?HabitCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, HabitRecord>
     */
    public function getHabitRecords(): Collection
    {
        return $this->habitRecords;
    }

    public function addHabitRecord(HabitRecord $habitRecord): self
    {
        if (!$this->habitRecords->contains($habitRecord)) {
            $this->habitRecords->add($habitRecord);
            $habitRecord->setHabit($this);
        }

        return $this;
    }

    public function removeHabitRecord(HabitRecord $habitRecord): self
    {
        if ($this->habitRecords->removeElement($habitRecord)) {
            // set the owning side to null (unless already changed)
            if ($habitRecord->getHabit() === $this) {
                $habitRecord->setHabit(null);
            }
        }

        return $this;
    }
}
