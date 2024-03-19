<?php

namespace App\Entity;

use App\Repository\StatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
class Statut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couleur = null;

    #[ORM\OneToMany(targetEntity: Projet::class, mappedBy: 'statut')]
    private Collection $projets;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'statuts')]
    private ?self $statut = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'statut')]
    private Collection $statuts;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->statuts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setStatut($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getStatut() === $this) {
                $projet->setStatut(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?self
    {
        return $this->statut;
    }

    public function setStatut(?self $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getStatuts(): Collection
    {
        return $this->statuts;
    }

    public function addStatut(self $statut): static
    {
        if (!$this->statuts->contains($statut)) {
            $this->statuts->add($statut);
            $statut->setStatut($this);
        }

        return $this;
    }

    public function removeStatut(self $statut): static
    {
        if ($this->statuts->removeElement($statut)) {
            // set the owning side to null (unless already changed)
            if ($statut->getStatut() === $this) {
                $statut->setStatut(null);
            }
        }

        return $this;
    }
}
