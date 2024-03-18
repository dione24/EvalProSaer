<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $roles = ['ROLE_ADMIN', 'ROLE_MANAGER', 'ROLE_USER'];
        $defaultPassword = 'password';

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $defaultPassword
            ));
            $user->setEmail('user' . $i . '@example.com');
            $user->setRoles([$roles[array_rand($roles)]]);
            $user->setNom('nom' . $i);
            $user->setPrenom('prenom' . $i);
            $manager->persist($user);
        }

        $manager->flush();
    }
}