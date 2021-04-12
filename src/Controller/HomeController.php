<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\FrontPageRepository;
use App\Repository\ListingCategoryRepository;
use App\Repository\ListingCityRepository;
use App\Repository\ListingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        Request $request, 
        EntityManagerInterface $manager, 
        UserPasswordEncoderInterface $encoder,
        FrontPageRepository $front_repo,
        ListingCategoryRepository $listing_cat_repo,
        ListingRepository $listing_repo,
        ListingCityRepository $listig_city_repo
        ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setToken("12345678");

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render('home/index.html.twig',[
            'form' => $form->createView(),
            'fronts' => $front_repo->findBy(['id'=> 1]),
            'cats' => $listing_cat_repo->findBy([],['id'=> 'DESC'],3),
            'listings' => $listing_repo->findBy([],['id'=> 'DESC'],3),
            'first' => $listig_city_repo->findBy([],['id'=> 'ASC'], 1)[0],
            'second' => $listig_city_repo->findBy([],['id'=> 'ASC'], 1,1)[0],
            'third' => $listig_city_repo->findBy([],['id'=> 'DESC'], 1)[0],
            'fourth' => $listig_city_repo->findBy([],['id'=> 'DESC'], 1,1)[0],
        ]);
    }
}
