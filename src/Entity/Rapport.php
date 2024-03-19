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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consultant", mappedBy="rapports")
     */
    private $consultants;

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

    #[ORM\Column(type: Types::TEXT, nullable: true)] // Permettre les valeurs NULL
    private ?string $evaluation_responsable = null;

    #[ORM\ManyToOne(inversedBy: 'rapport')]
    private ?Consultant $consultant = null;

    #[ORM\ManyToOne(inversedBy: 'rapports')]
    private ?Taches $tache = null;

    public function __construct()
    {
        $this->consultants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriode(): ?\DateTimeImmutable
    {
        return $this->periode;
    }

    public function setPeriode(\DateTimeImmutable $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * @return Collection|Consultant[]
     */
    public function getConsultants()
    {
        return $this->consultants;
    }

    public function addConsultant(Consultant $consultant): self
    {
        if (!$this->consultants->contains($consultant)) {
            $this->consultants[] = $consultant;
            $consultant->addRapport($this);
        }

        return $this;
    }

    public function removeConsultant(Consultant $consultant): self
    {
        $this->consultants->removeElement($consultant);
        $consultant->removeRapport($this);

        return $this;
    }

    public function getProjetId(): ?Projet
    {
        return $this->projet_id;
    }

    public function setProjetId(?Projet $projet_id): self
    {
        $this->projet_id = $projet_id;

        return $this;
    }

    public function getRealisations(): ?string
    {
        return $this->realisations;
    }

    public function setRealisations(string $realisations): self
    {
        $this->realisations = $realisations;

        return $this;
    }

    public function getDifficultes(): ?string
    {
        return $this->difficultes;
    }

    public function setDifficultes(string $difficultes): self
    {
        $this->difficultes = $difficultes;

        return $this;
    }

    public function getPropositionsInnovation(): ?string
    {
        return $this->propositions_innovation;
    }

    public function setPropositionsInnovation(string $propositions_innovation): self
    {
        $this->propositions_innovation = $propositions_innovation;

        return $this;
    }

    public function getAutoEvaluation(): ?string
    {
        return $this->auto_evaluation;
    }

    public function setAutoEvaluation(string $auto_evaluation): self
    {
        $this->auto_evaluation = $auto_evaluation;

        return $this;
    }

    public function getEvaluationResponsable(): ?string
    {
        return $this->evaluation_responsable;
    }

    public function setEvaluationResponsable(?string $evaluation_responsable): self
    {
        $this->evaluation_responsable = $evaluation_responsable;

        return $this;
    }

    public function getConsultant(): ?Consultant
    {
        return $this->consultant;
    }

    public function setConsultant(?Consultant $consultant): self
    {
        $this->consultant = $consultant;

        return $this;
    }

    public function getTache(): ?Taches
    {
        return $this->tache;
    }

    public function setTache(?Taches $tache): self
    {
        $this->tache = $tache;

        return $this;
    }
}
