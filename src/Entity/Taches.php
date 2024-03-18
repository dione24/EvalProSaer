<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TachesRepository::class)]
class Taches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Projet $projet_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dependance = null;

    #[ORM\Column(length: 255)]
    private ?string $priorite = null;

    #[ORM\Column]
    private ?float $estimation_temps = null;

    #[ORM\ManyToMany(targetEntity: Consultant::class, inversedBy: 'taches')]
    private Collection $consultant_id;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    public function __construct()
    {
        $this->consultant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjetId(): ?Projet
    {
        return $this->projet_id;
    }

    public function setProjetId(?Projet $projet_id): static
    {
        $this->projet_id = $projet_id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDependance(): ?string
    {
        return $this->dependance;
    }

    public function setDependance(?string $dependance): static
    {
        $this->dependance = $dependance;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): static
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getEstimationTemps(): ?float
    {
        return $this->estimation_temps;
    }

    public function setEstimationTemps(float $estimation_temps): static
    {
        $this->estimation_temps = $estimation_temps;

        return $this;
    }

    /**
     * @return Collection<int, Consultant>
     */
    public function getConsultantId(): Collection
    {
        return $this->consultant_id;
    }

    public function addConsultantId(Consultant $consultantId): static
    {
        if (!$this->consultant_id->contains($consultantId)) {
            $this->consultant_id->add($consultantId);
        }

        return $this;
    }

    public function removeConsultantId(Consultant $consultantId): static
    {
        $this->consultant_id->removeElement($consultantId);

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
