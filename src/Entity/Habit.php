<?php

namespace App\Entity;

use App\Entity\Traits\LifecycleTrait;
use App\Repository\HabitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use function strtolower;

#[ORM\Entity(repositoryClass: HabitRepository::class)]
#[ApiResource(
    attributes: ["security" => "is_granted('ROLE_ADMIN')"],
)]
class Habit
{
    use LifecycleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    /** Name of the habit */
    private ?string $name = null;

    #[ORM\Column(length: 6)]
    #[Assert\Regex('/^[a-fA-F0-9]{6}$/')]
    /** Color used to display the habit */
    private ?string $color = null;

    #[ORM\ManyToOne(inversedBy: 'habits')]
    /** Habit category */
    private ?HabitCategory $category = null;

    #[ORM\OneToMany(mappedBy: 'habit', targetEntity: HabitRecord::class, orphanRemoval: true)]
    /** Habit records */
    private Collection $habitRecords;

    public function __construct()
    {
        $this->habitRecords = new ArrayCollection();
        $this->lifeCycleTraitInit();
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
        // Only lowercase Hex codes
        $this->color = strtolower($color);

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
