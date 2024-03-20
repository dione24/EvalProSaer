<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Taches;
use App\Entity\Consultant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TachesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('priorite', IntegerType::class)
            ->add('estimation_temps', IntegerType::class)

            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'nom',
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
