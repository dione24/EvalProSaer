<?php

namespace App\Service;

use DateTimeImmutable;
use App\Entity\Commentaires;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class Comment
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function createCommentaire(Projet $projet, $content): void
    {
        // Créez un nouveau commentaire
        $commentaire = new Commentaires();
        $commentaire->setCreatedAt(new DateTimeImmutable());
        $commentaire->setUser($this->security->getUser());
        $commentaire->setProjet($projet);
        $commentaire->setUpdatedAt(new DateTimeImmutable());
        $commentaire->setContent($content);
        $this->entityManager->persist($commentaire);
        $this->entityManager->flush();
    }

    public function updateCommentaire(Commentaires $commentaire, $content): void
    {
        // Mettre à jour le commentaire
        $commentaire->setContent($content);
        $commentaire->setUpdatedAt(new DateTimeImmutable());
        $this->entityManager->flush();
    }


    public function deleteCommentaire(Commentaires $commentaire): void
    {
        $this->entityManager->remove($commentaire);
        $this->entityManager->flush();
    }
}
