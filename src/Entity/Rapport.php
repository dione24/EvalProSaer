<?php

namespace App\Entity;

use App\Entity\Projet;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RapportRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $periode = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resumeExecutif = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pointsSaillants = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resultatsObtenus = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $appreciationEvolutionActivite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $perspectives = null;

    #[ORM\ManyToOne(targetEntity: Taches::class, inversedBy: 'rapports')]
    private ?Taches $tache;


    /**
     * @ORM\ManyToOne(targetEntity: Consultant::class, inversedBy="rapports")
     */
    private ?Consultant $consultant;

    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'rapport')]
    private Collection $evaluations;

    #[ORM\ManyToOne(targetEntity: Projet::class, inversedBy: 'rapports')]
    private ?Projet $projet;

    #[ORM\ManyToOne(inversedBy: 'rapports')]
    private ?User $user = null;



    public function __construct()
    {
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

    public function getResumeExecutif(): ?string
    {
        return $this->resumeExecutif;
    }

    public function setResumeExecutif(?string $resumeExecutif): self
    {
        $this->resumeExecutif = $resumeExecutif;
        return $this;
    }

    public function getPointsSaillants(): ?string
    {
        return $this->pointsSaillants;
    }

    public function setPointsSaillants(?string $pointsSaillants): self
    {
        $this->pointsSaillants = $pointsSaillants;
        return $this;
    }

    public function getResultatsObtenus(): ?string
    {
        return $this->resultatsObtenus;
    }

    public function setResultatsObtenus(?string $resultatsObtenus): self
    {
        $this->resultatsObtenus = $resultatsObtenus;
        return $this;
    }

    public function getAppreciationEvolutionActivite(): ?string
    {
        return $this->appreciationEvolutionActivite;
    }

    public function setAppreciationEvolutionActivite(?string $appreciationEvolutionActivite): self
    {
        $this->appreciationEvolutionActivite = $appreciationEvolutionActivite;
        return $this;
    }

    public function getPerspectives(): ?string
    {
        return $this->perspectives;
    }

    public function setPerspectives(?string $perspectives): self
    {
        $this->perspectives = $perspectives;
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

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setRapport($this);
        }
        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            if ($evaluation->getRapport() === $this) {
                $evaluation->setRapport(null);
            }
        }
        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
