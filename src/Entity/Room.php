<?php

namespace App\Entity;

use App\Repository\RoomRepository;
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
     * @ORM\OneToMany(targetEntity=BuyIn::class, mappedBy="room", orphanRemoval=true)
     */
    private $buyIn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;


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


    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|BuyIn[]
     */
    public function getBuyIn(): Collection
    {
        return $this->buyIn;
    }

    public function addBuyIn(BuyIn $buyIn): self
    {
        if (!$this->buyIn->contains($buyIn)) {
            $this->buyIn[] = $buyIn;
            $buyIn->setRoom($this);
        }

        return $this;
    }

    public function removeBuyIn(BuyIn $buyIn): self
    {
        if ($this->buyIn->contains($buyIn)) {
            $this->buyIn->removeElement($buyIn);
            // set the owning side to null (unless already changed)
            if ($buyIn->getRoom() === $this) {
                $buyIn->setRoom(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }



}
