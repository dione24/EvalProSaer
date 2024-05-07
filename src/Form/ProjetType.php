<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Projet;
use App\Entity\Statut;
use Doctrine\DBAL\Types\BigIntType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du projet',
                'required' => true, // champ obligatoire
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du projet',
                ],
            ])
            ->add('client', TextType::class, [
                'label' => 'Nom du client',
                'required' => true, // champ obligatoire
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Exemple : Construction... ',

                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true, // champ obligatoire
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description du projet',
                    'required' => true
                ],
            ])
            ->add('date_debut', DateType::class, [
                'label' => 'Date de début',
                'required' => true, // champ obligatoire
                'attr' => [
                    'class' => 'form-control',
                    'required' => true
                ],
            ])
            ->add('date_fin', DateType::class, [
                'label' => 'Date de fin',
                'required' => true, // champ obligatoire
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'nom',
                'label' => 'Statut',
                'attr' => [
                    'class' => 'form-control',
                    'required' => true
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}