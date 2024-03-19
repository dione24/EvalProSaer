<?php

namespace App\Entity;

use App\Repository\ConsultantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultantRepository::class)]
class Consultant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $competences = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $disponibilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_profil = null;

    #[ORM\ManyToMany(targetEntity: Taches::class, mappedBy: 'consultant_id')]
    private Collection $taches;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: "consultant", cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Rapport::class, mappedBy: 'consultant')]
    private Collection $rapport;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->rapport = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetences(): ?string
    {
        return $this->competences;
    }

    public function setCompetences(string $competences): static
    {
        $this->competences = $competences;

        return $this;
    }

    public function getDisponibilite(): ?\DateTimeImmutable
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?\DateTimeImmutable $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getDescriptionProfil(): ?string
    {
        return $this->description_profil;
    }

    public function setDescriptionProfil(string $description_profil): static
    {
        $this->description_profil = $description_profil;

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
            $tach->addConsultantId($this);
        }

        return $this;
    }

    public function removeTach(Taches $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            $tach->removeConsultantId($this);
        }

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

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapport(): Collection
    {
        return $this->rapport;
    }

    public function addRapport(Rapport $rapport): static
    {
        if (!$this->rapport->contains($rapport)) {
            $this->rapport->add($rapport);
            $rapport->setConsultant($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): static
    {
        if ($this->rapport->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getConsultant() === $this) {
                $rapport->setConsultant(null);
            }
        }

        return $this;
    }
}
