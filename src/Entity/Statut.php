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

    #[ORM\OneToMany(targetEntity: Taches::class, mappedBy: 'statut')]
    private Collection $taches;


    #[ORM\OneToMany(targetEntity: Statut::class, mappedBy: 'statut')]
    private Collection $statuts;



    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->taches = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeStatut(self $statut): static
    {
        $this->statuts->removeElement($statut);

        return $this;
    }

    /**
     * @return Collection<int, Taches>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Taches $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setStatut($this);
        }

        return $this;
    }

    public function removeTach(Taches $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getStatut() === $this) {
                $tach->setStatut(null);
            }
        }

        return $this;
    }
}
