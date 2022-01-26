<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            "attr" => [
                "class" => "form-control",
            ],
            "label" => "Email"
        ])
        ->add('password', PasswordType::class, [
            "attr" => [
                "class" => "form-control"
            ],
            "label" => "Password"
        ])
        ->add('confirm_password', PasswordType::class, [
            "attr" => [
                "class" => "form-control"
            ],
            "label" => "Confirm Password"
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
