<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="2", minMessage="Ne peut pas faire moins de 2 caractères")
     * @Assert\Length(max="30", maxMessage="Ne peut pas faire plus de 30 caractères")
     * @Assert\NotNull(message = "Ne peut pas être vide")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="2", minMessage="Ne peut pas faire moins de 2 caractères")
     * @Assert\Length(max="30", maxMessage="Ne peut pas faire plus de 30 caractères")
     * @Assert\NotNull(message = "Ne peut pas être vide")
     */
    private $nameSpinAndGo;

    /**
     * @ORM\OneToMany(targetEntity=Multiplicator::class, mappedBy="room", orphanRemoval=true)
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNameSpinAndGo(): ?string
    {
        return $this->nameSpinAndGo;
    }

    public function setNameSpinAndGo(string $nameSpinAndGo): self
    {
        $this->nameSpinAndGo = $nameSpinAndGo;

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
            $multiplicator->setRoom($this);
        }

        return $this;
    }

    public function removeMultiplicator(Multiplicator $multiplicator): self
    {
        if ($this->multiplicators->contains($multiplicator)) {
            $this->multiplicators->removeElement($multiplicator);
            // set the owning side to null (unless already changed)
            if ($multiplicator->getRoom() === $this) {
                $multiplicator->setRoom(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
