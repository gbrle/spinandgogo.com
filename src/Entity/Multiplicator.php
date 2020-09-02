<?php

namespace App\Entity;

use App\Repository\MultiplicatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MultiplicatorRepository::class)
 */
class Multiplicator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=BuyIn::class, inversedBy="multiplicators")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyIn;

    /**
     * @ORM\OneToMany(targetEntity=Rank::class, mappedBy="multiplicator", orphanRemoval=true)
     */
    private $ranks;

    public function __construct()
    {
        $this->ranks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getBuyIn(): ?BuyIn
    {
        return $this->buyIn;
    }

    public function setBuyIn(?BuyIn $buyIn): self
    {
        $this->buyIn = $buyIn;

        return $this;
    }

    /**
     * @return Collection|Rank[]
     */
    public function getRanks(): Collection
    {
        return $this->ranks;
    }

    public function addRank(Rank $rank): self
    {
        if (!$this->ranks->contains($rank)) {
            $this->ranks[] = $rank;
            $rank->setMultiplicator($this);
        }

        return $this;
    }

    public function removeRank(Rank $rank): self
    {
        if ($this->ranks->contains($rank)) {
            $this->ranks->removeElement($rank);
            // set the owning side to null (unless already changed)
            if ($rank->getMultiplicator() === $this) {
                $rank->setMultiplicator(null);
            }
        }

        return $this;
    }
}
