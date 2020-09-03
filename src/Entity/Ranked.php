<?php

namespace App\Entity;

use App\Repository\RankedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RankedRepository::class)
 */
class Ranked
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
    private $position;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Multiplicator::class, inversedBy="rankeds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $multiplicator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMultiplicator(): ?Multiplicator
    {
        return $this->multiplicator;
    }

    public function setMultiplicator(?Multiplicator $multiplicator): self
    {
        $this->multiplicator = $multiplicator;

        return $this;
    }
}
