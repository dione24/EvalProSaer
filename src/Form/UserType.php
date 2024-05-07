<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Manager' => 'ROLE_MANAGER',
                    // Add more roles as needed
                ],
                'multiple' => true,
                'expanded' => true, // Display checkboxes for multiple selection
            ])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add(
                'email',
                EmailType::class
            );
        // je conditionne mon formulaire selon si on edit ou pas
        if ($options["custom_option"] !== "edit") {
            $builder->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => [
                    "label" => "Le mot de passe"
                ],
                "second_options" => [
                    "label" => "Répetez le mot de passe"
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'custom_option' => 'default'

        ]);
    }
}