<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Taches;
use App\Entity\Consultant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TachesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'label' => 'Description de la tâche',
                'required' => true,
            ])
            ->add('priorite', IntegerType::class, [
                'label' => 'Priorité',
                'required' => true,
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
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-control',
                    'required' => true
                ],
            ])
            ->add('consultants', EntityType::class, [
                'class' => Consultant::class,
                'choice_label' => 'user.nom',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Taches::class,
        ]);
    }
}