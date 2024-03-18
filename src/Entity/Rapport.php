<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $periode = null;

    #[ORM\ManyToMany(targetEntity: Consultant::class, inversedBy: 'projet_id')]
    private Collection $consultant_id;

    #[ORM\ManyToOne(inversedBy: 'rapports')]
    private ?Projet $projet_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $realisations = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $difficultes = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $propositions_innovation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $auto_evaluation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $evaluation_responsable = null;

    public function __construct()
    {
        $this->consultant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriode(): ?\DateTimeImmutable
    {
        return $this->periode;
    }

    public function setPeriode(\DateTimeImmutable $periode): static
    {
        $this->periode = $periode;

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

    public function getProjetId(): ?Projet
    {
        return $this->projet_id;
    }

    public function setProjetId(?Projet $projet_id): static
    {
        $this->projet_id = $projet_id;

        return $this;
    }

    public function getRealisations(): ?string
    {
        return $this->realisations;
    }

    public function setRealisations(string $realisations): static
    {
        $this->realisations = $realisations;

        return $this;
    }

    public function getDifficultes(): ?string
    {
        return $this->difficultes;
    }

    public function setDifficultes(string $difficultes): static
    {
        $this->difficultes = $difficultes;

        return $this;
    }

    public function getPropositionsInnovation(): ?string
    {
        return $this->propositions_innovation;
    }

    public function setPropositionsInnovation(string $propositions_innovation): static
    {
        $this->propositions_innovation = $propositions_innovation;

        return $this;
    }

    public function getAutoEvaluation(): ?string
    {
        return $this->auto_evaluation;
    }

    public function setAutoEvaluation(string $auto_evaluation): static
    {
        $this->auto_evaluation = $auto_evaluation;

        return $this;
    }

    public function getEvaluationResponsable(): ?string
    {
        return $this->evaluation_responsable;
    }

    public function setEvaluationResponsable(string $evaluation_responsable): static
    {
        $this->evaluation_responsable = $evaluation_responsable;

        return $this;
    }
}
