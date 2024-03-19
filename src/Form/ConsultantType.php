<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Taches;
use App\Entity\Consultant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConsultantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('competences', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('disponibilite', null, [
                'widget' => 'single_text',
            ])
            ->add('cv', FileType::class, [
                'label' => 'CV (PDF file)',
                'mapped' => false,
                'required' => false,

            ])
            ->add('description_profil', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultant::class,
        ]);
    }
}
