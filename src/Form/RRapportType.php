<?php

namespace App\Form;

use App\Entity\Consultant;
use App\Entity\Projet;
use App\Entity\Rapport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RRapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('periode', null, [
                'widget' => 'single_text',
            ])
            ->add('realisations')
            ->add('difficultes')
            ->add('propositions_innovation')
            ->add('auto_evaluation')
            ->add('evaluation_responsable')
            ->add('consultant_id', EntityType::class, [
                'class' => Consultant::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('projet_id', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
