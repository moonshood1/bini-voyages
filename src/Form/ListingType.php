<?php

namespace App\Form;

use App\Entity\Listing;
use App\Entity\ListingCategory;
use App\Entity\ListingImage;
use App\Form\ApplicationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfig("Titre du circuit",""))
            ->add('location',TextType::class,$this->getConfig("Localisation",""))
            ->add('contact',TextType::class,$this->getConfig("Numéro à contacter",""))
            ->add('description',TextareaType::class,$this->getConfig("Description du circuit",""))
            ->add('price',IntegerType::class,$this->getConfig("Montant de la réservation",""))
            ->add('main_image',UrlType::class,$this->getConfig("","Image de présentation du circuit"))
            ->add('images',CollectionType::class,[
                'entry_type'=> ListingImage::class,
                'allow_add' => true,
                'allow_delete' => true
                ])
            ->add('listing_category',EntityType::class,$this->getConfig("Catégorie du circuit","",['class'=> ListingCategory::class,'choice_label'=>'title']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
