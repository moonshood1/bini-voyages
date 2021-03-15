<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\BlogCategory;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfig("Titre de l'article",""))
            ->add('content',TextareaType::class,$this->getConfig("Contenu 1*",""))
            ->add('content_2',TextareaType::class,$this->getConfig("Contenu 2","Ce contenu n'est pas obligatoire"))
            ->add('content_3',TextareaType::class,$this->getConfig("Contenu 3","Ce contenu n'est pas obligatoire"))
            ->add('main_image',UrlType::class,$this->getConfig("Image principale de l'article*","Entrez l'url de l'image"))
            ->add('second_image',UrlType::class,$this->getConfig("Seconde Image","Entrez l'url de l'image"))
            ->add('third_image',UrlType::class,$this->getConfig("Troisieme Image","Entrez l'url de l'image"))
            ->add('fourth_image',UrlType::class,$this->getConfig("Quatrieme Image","Entrez l'url de l'image"))
            ->add('fifth_image',UrlType::class,$this->getConfig("Cinquieme Image","Entrez l'url de l'image"))
            ->add('blog_category',EntityType::class,$this->getConfig("Catégorie de l'article","",['class' => BlogCategory::class,'choice_label'=>'title']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
