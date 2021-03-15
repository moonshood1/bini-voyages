<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->getConfig("Prénom",""))
            ->add('lastName',TextType::class,$this->getConfig("Nom",""))
            ->add('email',EmailType::class,$this->getConfig("Adresse Email",""))
            ->add('password',PasswordType::class,$this->getConfig("Mot de passe",""))
            ->add('confirmPassword',PasswordType::class,$this->getConfig("Confirmation du mot de passe",""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
