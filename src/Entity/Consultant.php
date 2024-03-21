<?php


namespace App\Entity;

use App\Entity\User;
use App\Entity\Taches;
use App\Entity\Rapport;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConsultantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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

    #[ORM\ManyToMany(targetEntity: Taches::class, mappedBy: 'consultants')]

    private Collection $taches;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: "consultant", cascade: ['persist', 'remove'])]
    private ?User $user = null;




    /**
     * @ORM\OneToMany(targetEntity: Rapport::class, mappedBy: "consultant")
     */
    private ArrayCollection $rapports;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->taches = new ArrayCollection();
        $this->rapports = new ArrayCollection(); // Initialize rapports as ArrayCollection
        $this->entityManager = $entityManager;
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
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        $this->rapports->add($rapport);

        // Let Doctrine manage the relationship
        $this->entityManager->persist($rapport);

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        $this->rapports->removeElement($rapport);

        // Let Doctrine manage the relationship
        $this->entityManager->remove($rapport);

        return $this;
    }
}
