<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\LifecycleTrait;
use App\Repository\HabitCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HabitCategoryRepository::class)]
#[ApiResource(
    attributes: ["security" => "is_granted('ROLE_USER')"],
)]
class HabitCategory
{
    use LifecycleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    /** Category name */
    private ?string $name = null;

    #[ORM\Column(length: 6)]
    #[Assert\Regex('/^[a-fA-F0-9]{6}$/')]
    /** Color used to display the category */
    private ?string $color = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Habit::class)]
    /** Habits in this category */
    private Collection $habits;

    public function __construct()
    {
        $this->habits = new ArrayCollection();
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

    /**
     * @return Collection<int, Habit>
     */
    public function getHabits(): Collection
    {
        return $this->habits;
    }

    public function addHabit(Habit $habit): self
    {
        if (!$this->habits->contains($habit)) {
            $this->habits->add($habit);
            $habit->setCategory($this);
        }

        return $this;
    }

    public function removeHabit(Habit $habit): self
    {
        if ($this->habits->removeElement($habit)) {
            // set the owning side to null (unless already changed)
            if ($habit->getCategory() === $this) {
                $habit->setCategory(null);
            }
        }

        return $this;
    }
}
