<?php

namespace App\Entity;

use App\Repository\RoomRepository;
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
}
