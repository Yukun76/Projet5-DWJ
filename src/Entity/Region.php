<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Animal;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * One Region has Many Animal.
     * @OneToMany(targetEntity="Animal", mappedBy="region")
     */
    private $animal;


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


    public function getAnimal(): string
    {
        return $this->animal;
    }

    public function setAnimal(string $name): self
    {
        $this->animal = $animal;

        return $this;
    }

    public function __toString() 
    {
        return (string) $this->name; 
    }
}
