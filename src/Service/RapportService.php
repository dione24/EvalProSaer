<?php

namespace App\Service;

use App\Entity\Evaluation;
use App\Entity\Rapport;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class RapportService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addEvaluation(Rapport $rapport, User $user, string $content): Evaluation
    {
        $evaluation = new Evaluation();
        $evaluation->setRapport($rapport);
        $evaluation->setUser($user);
        $evaluation->setContent($content);

        $this->em->persist($evaluation);
        $this->em->flush();

        return $evaluation;
    }
}
