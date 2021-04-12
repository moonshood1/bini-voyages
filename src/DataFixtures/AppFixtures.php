<?php

namespace App\DataFixtures;

use App\Entity\FrontPage;
use App\Entity\ListingCategory;
use App\Entity\Role;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole->setTitle("ROLE_ADMIN");
                                            
        $manager->persist($adminRole);

        $ultimate = new User();
        $ultimate->setFirstName("Louis Roger")
                 ->setLastName("Guirika")
                 ->setAddress("Cocody Deux plateaux duncan")
                 ->setPassword($this->encoder->encodePassword($ultimate,"12345678"))
                 ->setRegisteredAt(new DateTime('now'))
                 ->setEmail("louisroger@live.fr")
                 ->setIsActive(true)
                 ->setUserPhone("0708990169")
                 ->setPicture("https://randomuser.me/api/portraits/women/56.jpg")
                 ->addUserRole($adminRole);
        $manager->persist($ultimate);


        $gastro = new ListingCategory();
        $gastro->setTitle("Gastro")->setCategoryIcon("fas fa-utensils");
        $manager->persist($gastro);

        $farniente = new ListingCategory();
        $farniente->setTitle("Farniente")->setCategoryIcon("fas fa-glass-martini");
        $manager->persist($farniente);

        $aventure = new ListingCategory();
        $aventure->setTitle("Aventure")->setCategoryIcon("fas fa-binoculars");
        $manager->persist($aventure);

        $front = new FrontPage();
        $front->setFrontTitle("Trouvez des activités à proximité")
              ->setFrontMainImage("http://binivoyages.com/wp-content/uploads/2021/03/bini-voyages-background.jpg")
              ->setFrontIntroduction("Explorez les attractions, les activités et plus encore avec Bini Voyages")
              ->setFrontFooterAbout("Bini Voyages Est Une Agence De Voyage Sur Mesure Qui Propose Des Séjours Et Circuits 
              Écotouristiques Dans Toute La Cote D’Ivoire. Elle Vous Propose Des Circuits De 1 À 10 Jours, 
              En Pleine Immersion Dans La Nature, Hors Des Sentiers Battus. Nous Sommes Au Cœur De L’action 
              Afin De Répondre Au Mieux À Vos Besoins. ")
              ->setFrontFooterContact1("+225 07 87 84 94 43")
              ->setFrontFooterContact2("+225 07 08 33 47 73")
              ->setFrontFooterEmail("domainebinivoyage@.eco")
              ->setFrontFooterLocation("Domaine Bini forêt Km 51 sur l'autoroute du nord (Côte d’Ivoire)")
              ->setFrontFooterFacebook("https://liens-rs.com")
              ->setFrontFooterTwitter("https://liens-rs.com")
              ->setFrontFooterInstagram("https://liens-rs.com");
        $manager->persist($front);

        $manager->flush();
    }
}
