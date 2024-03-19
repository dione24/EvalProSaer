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



    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $priorite = null;

    #[ORM\Column]
    private ?float $estimation_temps = null;

    #[ORM\ManyToMany(targetEntity: Consultant::class, inversedBy: 'taches')]
    private Collection $consultant_id;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Projet $projet = null;

    #[ORM\OneToMany(targetEntity: Rapport::class, mappedBy: 'tache')]
    private Collection $rapports;

    public function __construct()
    {
        $this->consultant_id = new ArrayCollection();
        $this->rapports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): static
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports->add($rapport);
            $rapport->setTache($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): static
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getTache() === $this) {
                $rapport->setTache(null);
            }
        }

        return $this;
    }
}
