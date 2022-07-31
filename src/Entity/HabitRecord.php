<?php

namespace App\Entity;

use App\Entity\Traits\LifecycleTrait;
use App\Repository\HabitRecordRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitRecordRepository::class)]
class HabitRecord
{
    use LifecycleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCompleted = null;

    #[ORM\ManyToOne(inversedBy: 'habitRecords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habit $habit = null;

    public function __construct()
    {
        $this->lifeCycleTraitInit();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCompleted(): ?\DateTimeInterface
    {
        return $this->dateCompleted;
    }

    public function setDateCompleted(?\DateTimeInterface $dateCompleted): self
    {
        $this->dateCompleted = $dateCompleted;

        return $this;
    }

    public function getHabit(): ?Habit
    {
        return $this->habit;
    }

    public function setHabit(?Habit $habit): self
    {
        $this->habit = $habit;

        return $this;
    }
}
