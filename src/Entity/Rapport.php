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
    private ?Projet $projet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $realisations = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $difficultes = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $propositions_innovation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $auto_evaluation = null;



    #[ORM\ManyToOne(inversedBy: 'rapport')]
    private ?Consultant $consultant = null;


    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'rapport')]
    private Collection $evaluations;

    public function __construct()
    {
        $this->consultants = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
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
        return $this->projet;
    }

    public function setProjetId(?Projet $projet): self
    {
        $this->projet = $projet;

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


    public function getConsultant(): ?Consultant
    {
        return $this->consultant;
    }

    public function setConsultant(?Consultant $consultant): self
    {
        $this->consultant = $consultant;

        return $this;
    }


    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->setRapport($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getRapport() === $this) {
                $evaluation->setRapport(null);
            }
        }

        return $this;
    }
}
