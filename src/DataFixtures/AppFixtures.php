<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Statut;
use DateTimeImmutable;
use App\Repository\GenreRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {


        // ! Users

        $users = [
            [
                "username" => "consultant",
                "nom" => "consultant",
                "prenom" => "consultant",
                "email" => "consultat@evalpro.saer",
                // password consultant
                "password" => "consultant",
                "role" => ["ROLE_CONSULTANT"]

            ],
            [
                "username" => "manager",
                "nom" => "manager",
                "prenom" => "manager",

                "email" => "manager@manager.com",
                // password manager
                "password" => "manager",
                "role" => ["ROLE_MANAGER"]
            ],
            [
                "username" => "admin",
                "nom" => "admin",
                "prenom" => "admin",
                "email" => "admin@admin.com",
                // password admin
                "password" => "admin",
                "role" => ["ROLE_ADMIN"]
            ],

        ];

        foreach ($users as $userData) {
            // je crée un user
            $user = new User;
            // je lui donne un username
            $user->setUsername($userData['username']);
            // je lui donne un nom
            $user->setNom($userData['nom']);
            // je lui donne un prenom
            $user->setPrenom($userData['prenom']);
            // je lui donne un email
            $user->setEmail($userData['email']);
            // je lui donne un mot de passe
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $userData['password']
            ));
            // je lui donne un role
            $user->setRoles($userData['role']);
            // je demande à doctrine de sauvegarder mon user
            $manager->persist($user);
        }

        // on demande d'exécuter les requetes
        $manager->flush();


        //add  Statut de tache
        $statut = [
            "En cours",
            "Terminé",
            "En attente",
            "Annulé"
        ];
        foreach ($statut as $value) {
            $statut = new Statut;
            $statut->setNom($value);
            $statut->setCouleur("#" . substr(md5(rand()), 0, 6));
            $manager->persist($statut);
        }
    }
}
