<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Rapport;
use App\Entity\Consultant;
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
            $accessibleProjects = $this->entityManager->getRepository(Projet::class)->findProjetByUser($user);
            // Suppose que la méthode findProjetByUser() renvoie les projets accessibles pour le consultant
        } else {
            // Pour d'autres rôles comme manager ou admin, récupérez tous les projets
            $accessibleProjects = $this->entityManager->getRepository(Projet::class)->findAll();
        }

        $builder
            ->add('periode', DateType::class, [
                'label' => 'Période',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('realisations', TextareaType::class, [
                'label' => 'Réalisations',
            ])
            ->add('difficultes', TextareaType::class, [
                'label' => 'Difficultés',
            ])
            ->add('propositions_innovation', TextareaType::class, [
                'label' => 'Propositions d\'innovation',
            ])
            ->add('auto_evaluation', TextareaType::class, [
                'label' => 'Auto-évaluation',
            ]);

        // Ajouter le champ projet_id avec les projets accessibles pour l'utilisateur
        $builder->add('projet_id', EntityType::class, [
            'class' => Projet::class,
            'choices' => $accessibleProjects,
            'choice_label' => 'nom',
        ]);

        // Si le rôle est consultant, le champ consultants ne sera pas multiple
        if (!$isConsultant) {
            $builder->add('consultants', EntityType::class, [
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
