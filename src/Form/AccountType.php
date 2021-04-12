<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->getConfig("Prénom",""))
            ->add('lastName',TextType::class,$this->getConfig("Nom",""))
            ->add('email',EmailType::class,$this->getConfig("Adresse email",""))
            ->add('picture',UrlType::class,$this->getConfig("Url de l'image de profil",""))
            ->add('address',TextType::class,$this->getConfig("Adresse complète",""))
            ->add('userPhone',TextType::class,$this->getConfig("Numéro de téléphone",""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
