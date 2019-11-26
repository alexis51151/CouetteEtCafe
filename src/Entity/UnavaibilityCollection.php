<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnavaibilityCollectionRepository")
 */
class UnavaibilityCollection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Unavaibility", mappedBy="unavaibilityCollection")
     */
    private $unavaibilities;

    public function __construct()
    {
        $this->unavaibilities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Unavaibility[]
     */
    public function getUnavaibilities(): Collection
    {
        return $this->unavaibilities;
    }

    public function addUnavaibility(Unavaibility $unavaibility): self
    {
        if (!$this->unavaibilities->contains($unavaibility)) {
            $this->unavaibilities[] = $unavaibility;
            $unavaibility->setUnavaibilityCollection($this);
        }

        return $this;
    }

    public function removeUnavaibility(Unavaibility $unavaibility): self
    {
        if ($this->unavaibilities->contains($unavaibility)) {
            $this->unavaibilities->removeElement($unavaibility);
            // set the owning side to null (unless already changed)
            if ($unavaibility->getUnavaibilityCollection() === $this) {
                $unavaibility->setUnavaibilityCollection(null);
            }
        }

        return $this;
    }
}
