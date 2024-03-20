<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'evaluations')]
    private ?User $responsable = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_evaluation = null;

    #[ORM\ManyToOne(targetEntity: Rapport::class, inversedBy: 'evaluations')]
    private ?Rapport $rapport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponsable(): ?User
    {
        return $this->responsable;
    }

    public function setResponsable(?User $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateEvaluation(): ?\DateTimeImmutable
    {
        return $this->date_evaluation;
    }

    public function setDateEvaluation(\DateTimeImmutable $date_evaluation): static
    {
        $this->date_evaluation = $date_evaluation;

        return $this;
    }

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): static
    {
        $this->rapport = $rapport;

        return $this;
    }
}
