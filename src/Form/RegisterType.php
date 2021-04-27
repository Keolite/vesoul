<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                EmailType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Adresse mail',
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'confirm_password',
                PasswordType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Confirmation du mot de passe',
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Prénom',
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Nom',
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'label' => false,
                    'attr' =>
                    [
                        'class' => 'register-gender mb-3'
                    ],
                    'data' => 0,
                    'choices' => [
                        'Homme' => 0,
                        'Femme' => 1
                    ],
                    'expanded' => true,
                ]
            )
            ->add(
                'tel',
                TelType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Télephone',
                        'class' => 'form-control',
                    ]
                ]

            )
            ->add(
                'birth',
                DateType::class,
                [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Date de naissance',
                        'class' => 'form-control',
                    ],
                    'widget' => 'single_text'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
