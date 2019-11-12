<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnavailabilitiesRepository")
 */
class Unavailabilities
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="unavailabilities")
     */
    private $Room;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $dates = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->Room;
    }

    public function setRoom(?Room $Room): self
    {
        $this->Room = $Room;

        return $this;
    }

    public function getDates(): ?array
    {
        return $this->dates;
    }

    public function setDates(?array $dates): self
    {
        $this->dates = $dates;

        return $this;
    }
}
