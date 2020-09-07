<?php

namespace App\Entity;

use App\Repository\BuyInRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BuyInRepository::class)
 */
class BuyIn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("buy_in")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups("buy_in")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Room::class, inversedBy="buyIn")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room;

    /**
     * @ORM\OneToMany(targetEntity=Multiplicator::class, mappedBy="buyIn", orphanRemoval=true)
     */
    private $multiplicators;

    public function __construct()
    {
        $this->multiplicators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

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

    /**
     * @return Collection|Multiplicator[]
     */
    public function getMultiplicators(): Collection
    {
        return $this->multiplicators;
    }

    public function addMultiplicator(Multiplicator $multiplicator): self
    {
        if (!$this->multiplicators->contains($multiplicator)) {
            $this->multiplicators[] = $multiplicator;
            $multiplicator->setBuyIn($this);
        }

        return $this;
    }

    public function removeMultiplicator(Multiplicator $multiplicator): self
    {
        if ($this->multiplicators->contains($multiplicator)) {
            $this->multiplicators->removeElement($multiplicator);
            // set the owning side to null (unless already changed)
            if ($multiplicator->getBuyIn() === $this) {
                $multiplicator->setBuyIn(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
