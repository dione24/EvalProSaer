<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Rapport;
use App\Entity\Consultant;
use App\Entity\Taches;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RapportType extends AbstractType
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isConsultant = $this->security->isGranted('ROLE_CONSULTANT');
        $user = $this->security->getUser();

        // Récupérer les projets accessibles par l'utilisateur en fonction de son rôle
        if ($isConsultant) {
            $accessibleTaches = $this->entityManager->getRepository(Taches::class)->findTachesByUser($user);
            // Suppose que la méthode findProjetByUser() renvoie les projets accessibles pour le consultant
            $accessibleProjets = $this->entityManager->getRepository(Projet::class)->findUserProject($user);
        } else {
            // Pour d'autres rôles comme manager ou admin, récupérez tous les projets
            $accessibleTaches = $this->entityManager->getRepository(Taches::class)->findAll();
            $accessibleProjets = $this->entityManager->getRepository(Projet::class)->findAll();
        }

        $builder
            ->add('periode', DateType::class, [
                'label' => 'Période',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('resumeExecutif', TextareaType::class, [
                'label' => 'Résumé exécutif',
                'attr' => ['rows' => 5]
            ])
            ->add('pointsSaillants', TextareaType::class, [
                'label' => 'Points saillants',
                'attr' => ['rows' => 5]
            ])
            ->add('resultatsObtenus', TextareaType::class, [
                'label' => 'Résultats obtenus',
                'attr' => ['rows' => 5]
            ])
            ->add('appreciationEvolutionActivite', TextareaType::class, [
                'label' => 'Appréciation de l\'évolution de l\'activité',
                'attr' => ['rows' => 5]
            ])
            ->add('perspectives', TextareaType::class, [
                'label' => 'Perspectives',
                'attr' => ['rows' => 5]
            ]);

        // $builder->add(
        //     'projet',
        //     EntityType::class,
        //     [
        //         'class' => Projet::class,
        //         'choices' => $accessibleProjets,
        //         'label' => 'Projet',
        //         'choice_label' => function ($projet) {
        //             return $projet->getNom();
        //         },
        //     ]
        // );



        // Ajouter le champ projet_id avec les projets accessibles pour l'utilisateur
        // $builder->add('tache', EntityType::class, [
        //     'class' => Taches::class,
        //     'choices' => $accessibleTaches,
        //     'label' => 'Tâche',
        //     'choice_label' => function ($tache) {
        //         return $tache->getDescription() . ' - ' . $tache->getProjet()->getNom();
        //     },
        // ]);

        // Si le rôle est consultant, le champ consultants ne sera pas multiple
        if (!$isConsultant) {
            $builder->add('consultant', EntityType::class, [
                'class' => Consultant::class,
                'choice_label' => function ($consultant) {
                    return $consultant->getUser()->getNom(); // Assurez-vous que cette méthode renvoie le nom de l'utilisateur du consultant
                },
                'multiple' => true,
                // Set 'required' to false to allow null consultant_id
                'required' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
