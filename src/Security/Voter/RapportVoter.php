<?php

namespace App\Security\Voter;

use App\Entity\Rapport;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RapportVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // Voter uniquement sur les actions 'CREATE' sur des objets Rapport
        return $attribute === 'CREATE' && $subject instanceof Rapport;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Vérifier si l'utilisateur est authentifié
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Vérifier si l'utilisateur a le rôle CONSULTANT
        if (in_array('ROLE_CONSULTANT', $user->getRoles())) {
            // L'utilisateur a le rôle CONSULTANT, donc autoriser la création de rapport
            return true;
        }

        // Si l'utilisateur n'a pas le rôle CONSULTANT, alors il ne peut pas créer de rapport
        return false;
    }
}
