<?php

namespace App\Entity;

use App\Repository\MultiplicatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MultiplicatorRepository::class)
 */
class Multiplicator
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("multiplicator")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups("multiplicator")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=BuyIn::class, inversedBy="multiplicators")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyIn;

    /**
     * @ORM\OneToMany(targetEntity=Ranked::class, mappedBy="multiplicator", orphanRemoval=true)
     */
    private $rankeds;

    public function __construct()
    {
        $this->rankeds = new ArrayCollection();
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
     * @return Collection|Ranked[]
     */
    public function getRankeds(): Collection
    {
        return $this->rankeds;
    }

    public function addRanked(Ranked $ranked): self
    {
        if (!$this->rankeds->contains($ranked)) {
            $this->rankeds[] = $ranked;
            $ranked->setMultiplicator($this);
        }

        return $this;
    }

    public function removeRanked(Ranked $ranked): self
    {
        if ($this->rankeds->contains($ranked)) {
            $this->rankeds->removeElement($ranked);
            // set the owning side to null (unless already changed)
            if ($ranked->getMultiplicator() === $this) {
                $ranked->setMultiplicator(null);
            }
        }

        return $this;
    }
}
