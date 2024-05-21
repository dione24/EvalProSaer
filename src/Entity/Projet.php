<?php


// src/Entity/Projet.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $client = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Rapport::class)]
    private Collection $rapports;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    private ?Statut $statut = null;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Taches::class)]
    private Collection $taches;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Commentaires::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Fichiers::class)]
    private Collection $fichiers;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->fichiers = new ArrayCollection();
    }

    // Getters et setters

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

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): static
    {
        $this->client = $client;
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

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeImmutable $date_fin): static
    {
        $this->date_fin = $date_fin;
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
            $rapport->setProjet($this);
        }
        return $this;
    }

    public function removeRapport(Rapport $rapport): static
    {
        if ($this->rapports->removeElement($rapport)) {
            if ($rapport->getProjet() === $this) {
                $rapport->setProjet(null);
            }
        }
        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): static
    {
        $this->statut = $statut;
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
            $tach->setProjet($this);
        }
        return $this;
    }

    public function removeTach(Taches $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            if ($tach->getProjet() === $this) {
                $tach->setProjet(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setProjet($this);
        }
        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            if ($commentaire->getProjet() === $this) {
                $commentaire->setProjet(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Fichiers>
     */
    public function getFichiers(): Collection
    {
        return $this->fichiers;
    }

    public function addFichier(Fichiers $fichier): static
    {
        if (!$this->fichiers->contains($fichier)) {
            $this->fichiers->add($fichier);
            $fichier->setProjet($this);
        }
        return $this;
    }

    public function removeFichier(Fichiers $fichier): static
    {
        if ($this->fichiers->removeElement($fichier)) {
            if ($fichier->getProjet() === $this) {
                $fichier->setProjet(null);
            }
        }
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
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