<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Projet;

class ProjetVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Projet;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Si l'utilisateur est anonyme, ne pas accorder l'accès
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Si l'utilisateur est un administrateur ou un manager, accorder l'accès
        if (in_array('ROLE_ADMIN', $user->getRoles()) || in_array('ROLE_MANAGER', $user->getRoles())) {
            return true;
        }

        // Si l'utilisateur est un consultant, vérifier s'il est affecté au projet
        if ($attribute === self::VIEW) {
            $projet = $subject;

            // Mettez ici la logique pour vérifier si le projet est affecté au consultant
            // Par exemple, vous pouvez vérifier si le consultant est affecté à l'une des tâches du projet
            // Si le consultant est affecté, accorder l'accès
            // Sinon, refuser l'accès
            // Exemple de logique à remplacer par votre propre logique :
            foreach ($projet->getTaches() as $tache) {
                foreach ($tache->getConsultantId() as $consultant) {
                    if ($consultant->getId() === $user->getId()) {
                        return true;
                    }
                }
            }
        }

        // Par défaut, refuser l'accès
        return false;
    }
}
