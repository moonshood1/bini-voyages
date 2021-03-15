<?php

namespace App\Form;

use App\Entity\FrontPage;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontPageType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('front_title',TextType::class,$this->getConfig("Titre principal de l'accueil",""))
            ->add('front_introduction',TextareaType::class,$this->getConfig("Phrase Introductive",""))
            ->add('front_main_image',UrlType::class,$this->getConfig("Image de background de l'accueil",""))
            ->add('front_footer_about',TextareaType::class,$this->getConfig("Texte à propos",""))
            ->add('front_footer_location',TextType::class,$this->getConfig("Localisation de bini-voyages",""))
            ->add('front_footer_website',UrlType::class,$this->getConfig("Site web de bini-voyages",""))
            ->add('front_footer_contact_1',TextType::class,$this->getConfig("Contact 1",""))
            ->add('front_footer_contact_2',TextType::class,$this->getConfig("Contact 2",""))
            ->add('front_footer_email',EmailType::class,$this->getConfig("Adresse email de bini-voyages",""))
            ->add('front_footer_facebook',UrlType::class,$this->getConfig("Lien facebook",""))
            ->add('front_footer_twitter',UrlType::class,$this->getConfig("Lien Twitter",""))
            ->add('front_footer_instagram',UrlType::class,$this->getConfig("Lien Instagram",""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FrontPage::class,
        ]);
    }
}
