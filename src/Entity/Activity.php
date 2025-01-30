<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Activity implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_end = null;

    #[ORM\ManyToOne(targetEntity: ActivityType::class, inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ActivityType $activityType = null;

    #[ORM\ManyToMany(targetEntity: Monitor::class)]
    #[ORM\JoinTable(name: 'activity_monitor')]
    private Collection $monitors;

    public function __construct()
    {
        $this->monitors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;
        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): static
    {
        $this->date_end = $date_end;
        return $this;
    }

    public function getActivityType(): ?ActivityType
    {
        return $this->activityType;
    }

    public function setActivityType(?ActivityType $activityType): static
    {
        $this->activityType = $activityType;
        return $this;
    }

    public function getMonitors(): Collection
    {
        return $this->monitors;
    }

    public function addMonitor(Monitor $monitor): static
    {
        if (!$this->monitors->contains($monitor)) {
            $this->monitors->add($monitor);
        }
        return $this;
    }

    public function removeMonitor(Monitor $monitor): static
    {
        $this->monitors->removeElement($monitor);
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'date_start' => $this->date_start->format('Y-m-d H:i:s'),
            'date_end' => $this->date_end->format('Y-m-d H:i:s'),
            'activity_type' => $this->activityType ? ['id' => $this->activityType->getId(), 'name' => $this->activityType->getName()] : null
        ];
    }
}
