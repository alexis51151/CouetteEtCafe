<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnavaibilityRepository")
 */
class Unavaibility
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="unavaibilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UnavaibilityCollection", inversedBy="unavaibilities")
     */
    private $unavaibilityCollection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getUnavaibilityCollection(): ?UnavaibilityCollection
    {
        return $this->unavaibilityCollection;
    }

    public function setUnavaibilityCollection(?UnavaibilityCollection $unavaibilityCollection): self
    {
        $this->unavaibilityCollection = $unavaibilityCollection;

        return $this;
    }
}
