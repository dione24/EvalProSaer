<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Taches;
use App\Entity\Consultant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TachesType extends AbstractType
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
            // Suppose que la méthode findProjetByUser() renvoie les projets accessibles pour le consultant
            $accessibleProjets = $this->entityManager->getRepository(Projet::class)->findUserProject($user);
        } else {
            // Pour d'autres rôles comme manager ou admin, récupérez tous les projets
            $accessibleProjets = $this->entityManager->getRepository(Projet::class)->findAll();
        }
        $builder
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Description de la tâche',
                'required' => true,
            ])
            ->add('priorite', IntegerType::class, [
                'label' => 'Priorité',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                ]
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début',
                'attr' => [
                    'class' => 'form-control',
                    'required' => true
                ],
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin',
                'attr' => [
                    'class' => 'form-control',
                    'required' => true
                ],
            ])
            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'choices' => $accessibleProjets,
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                    'required' => true
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Taches::class,
        ]);
    }
}
