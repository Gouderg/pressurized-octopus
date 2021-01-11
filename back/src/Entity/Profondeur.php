<?php

namespace App\Entity;

use App\Repository\ProfondeurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfondeurRepository::class)
 */
class Profondeur
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
    private $profondeur;

    /**
     * @ORM\ManyToOne(targetEntity=Tableplongee::class)
     */
    private $correspond;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfondeur(): ?int
    {
        return $this->profondeur;
    }

    public function setProfondeur(int $profondeur): self
    {
        $this->profondeur = $profondeur;

        return $this;
    }

    public function getCorrespond(): ?Tableplongee
    {
        return $this->correspond;
    }

    public function setCorrespond(?Tableplongee $correspond): self
    {
        $this->correspond = $correspond;

        return $this;
    }
}
