<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PostPersist;
use Doctrine\ORM\Mapping\PostUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

#[HasLifecycleCallbacks]
trait LifecycleTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $createdDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $updatedDate;

    /**
     * "Constructeur" du trait, à appeler dans le constructeur des classes qui en héritent
     */
    private function lifeCycleTraitInit()
    {
        $this->createdDate = new DateTime();
        $this->updatedDate = new DateTime();
    }

    #[PrePersist]
    public function onPrePersist()
    {
        $this->createdDate = new \DateTime('now');
    }

    #[PreUpdate]
    public function onPreUpdate()
    {
        $this->updatedDate = new \DateTime('now');
    }

    public function getCreatedDate(): ?DateTimeInterface
    {
        return $this->createdDate;
    }

    #[PrePersist]
    public function setCreatedDate()
    {
        $this->createdDate = new DateTime();

        return $this;
    }

    public function getUpdatedDate(): ?DateTimeInterface
    {
        return $this->updatedDate;
    }

    #[PostUpdate]
    #[PostPersist]
    public function setUpdatedDate()
    {
        $this->updatedDate = new DateTime();

        return $this;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return $this
     */
    public function forceCreatedDate(DateTime $dateTime)
    {
        $this->createdDate = $dateTime;
        return $this;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return $this
     */
    public function forceUpdatedDate(DateTime $dateTime)
    {
        $this->updatedDate = $dateTime;
        return $this;
    }
}
