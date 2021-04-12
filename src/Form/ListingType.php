<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Listing;
use App\Form\ApplicationType;
use App\Form\ListingImageType;
use App\Entity\ListingCategory;
use App\Entity\ListingCity;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ListingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfig("Titre du circuit","ex: Evasion dans les domaines bini"))
            ->add('location',TextType::class,$this->getConfig("Localisation","ex: Domaine Bini 51km d'abidjan "))
            ->add('contact',TextType::class,$this->getConfig("Numéro à contacter","ex: +225 07 01 01 02 02"))
            ->add('description',TextareaType::class,$this->getConfig("Description du circuit",""))
            ->add('price',IntegerType::class,$this->getConfig("Montant de la réservation","ex:  300 000"))
            ->add('main_image',UrlType::class,$this->getConfig("Image principale du circuit","Entrez l'url de l'image de présentation du circuit"))
            ->add('images',CollectionType::class,$this->getConfig("Images du circuit","",[
                'entry_type'=> ListingImageType::class,
                'allow_add' => true,
                'allow_delete' => true
                ]))
            ->add('listing_category',EntityType::class,$this->getConfig("Catégorie du circuit","",['class'=> ListingCategory::class,'choice_label'=>'title']))
            ->add('country',EntityType::class,$this->getConfig("Pays du circuit","",['class'=> Country::class,'choice_label'=>'name']))
            ->add('city',EntityType::class,$this->getConfig("Ville du circuit","",['class'=> ListingCity::class,'choice_label'=>'name']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
