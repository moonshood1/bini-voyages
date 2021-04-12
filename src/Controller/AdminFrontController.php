<?php

namespace App\Controller;

use App\Entity\Guides;
use App\Entity\Country;
use App\Form\GuidesType;
use App\Entity\FrontPage;
use App\Form\CountryType;
use App\Entity\ListingCity;
use App\Form\CityType;
use App\Form\FrontPageType;
use App\Repository\GuidesRepository;
use App\Repository\CountryRepository;
use App\Repository\FrontPageRepository;
use App\Repository\ListingCityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminFrontController extends AbstractController
{
    /**
     * @Route("/admin/frontend", name="admin_frontend_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_frontend_index(FrontPageRepository $repo): Response
    {      
        return $this->render('admin/other/front/index.html.twig', [
            'fronts' => $repo->findBy(['id'=> 1])
        ]);
    }
    
    /**
     * @Route("/admin/frontend/{id}/edit", name="admin_frontend_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param FrontPage $front
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_frontend_edit(FrontPage $front,EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(FrontPageType::class,$front);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($front);
            $manager->flush();

            $this->addFlash('info', "Le frontend a bien été modifié");

            return $this->redirectToRoute("admin_frontend_index");
        }

        $breadcrumbs->prependRouteItem("FrontEnd","admin_frontend_index")
                    ->addRouteItem("Modification","admin_frontend_edit",['id'=> $front->getId()]);

        return $this->render('admin/other/front/edit.html.twig',[
            'front' => $front,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/guides", name="admin_guides_index")
     * @IsGranted("ROLE_ADMIN")
     * @param GuidesRepository $guides_repo
     */
    public function admin_guides_index(GuidesRepository $guides_repo)
    {
        return $this->render('admin/other/guides/index.html.twig',[
            'guides' => $guides_repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/guides/create", name="admin_guides_create")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_guides_create(EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
        $guide = new Guides();
        $form = $this->createForm(GuidesType::class,$guide);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($guide);
            $manager->flush();

            $this->addFlash('success',"Le guide {$guide->getGuideName()} a bien été créé !");
            return $this->redirectToRoute("admin_guides_index");
        }

        $breadcrumbs->prependRouteItem("Guides","admin_guides_index")
                    ->addRouteItem("Création","admin_guides_create");

        return $this->render('admin/other/guides/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/guides/{id}/edit", name="admin_guides_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_guides_edit(Guides $guide,EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
         $form = $this->createForm(GuidesType::class,$guide);
         $form->handleRequest($request);
         
         if ($form->isSubmitted() && $form->isValid()) {
             $manager->persist($guide);
             $manager->flush();

             $this->addFlash('info',"Le guide {$guide->getGuideName()} a bien été modifié !");
             return $this->redirectToRoute("admin_guides_index");
        }

        $breadcrumbs->prependRouteItem("Guides","admin_guides_index")
                    ->addRouteItem("Modification","admin_guides_edit",['id'=> $guide->getId()]);
        
        return $this->render('admin/other/guides/edit.html.twig',[
            'form' => $form->createView(),
             'guide' => $guide
        ]);
    }

    /**
     * @Route("/admin/guides/{id}/delete", name="admin_guides_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_guides_delete(Guides $guide,EntityManagerInterface $manager)
    {
        $manager->remove($guide);
        $manager->flush();

        $this->addFlash('danger',"Le guide {$guide->getGuideName()} a bien été retiré de la liste des guides !");
        return $this->redirectToRoute("admin_guides_index");
    }

    /**
     * @Route("/admin/country", name="admin_country_index")
     * @param CountryRepository $repo
     * @return Response
     */
    public function admin_country_index(CountryRepository $repo)
    {
        return $this->render('admin/other/country/index.html.twig',[
            'countries' => $repo->findAll()
        ]);
    }


    /**
     * @Route("/admin/country/create", name="admin_country_create")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function admin_country_create(EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class,$country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($country);
            $manager->flush();

            $this->addFlash("success","{$country->getName()} a bien été ajouté");

            return $this->redirectToRoute('admin_country_index');
        }

        $breadcrumbs->prependRouteItem("Pays","admin_country_index")
                    ->addRouteItem("Création","admin_country_create");

        return $this->render('admin/other/country/create.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/country/{id}/edit", name="admin_country_edit")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Country $country
     * @return Response
     */
    public function admin_country_edit(EntityManagerInterface $manager,Request $request,Country $country,Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(CountryType::class,$country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($country);
            $manager->flush();

            $this->addFlash("info","{$country->getName()} a bien été modifié ");

            return $this->redirectToRoute('admin_country_index');
        }

        $breadcrumbs->prependRouteItem("Pays","admin_country_index")
                    ->addRouteItem("Modification","admin_country_edit",['id'=> $country->getId()]);

        return $this->render('admin/other/country/edit.html.twig',[
            'form' => $form->createView(),
            'country' => $country
        ]);
    }

    /**
     * @Route("/admin/country/{id}/delete", name="admin_country_delete")
     * @param Country $country
     * @param EntityManagerInterface $manager
     */
    public function admin_country_delete(Country $country,EntityManagerInterface $manager)
    {
        if (count($country->getListing())) {
            $this->addFlash("warning","{$country->getName()} ne peut etre supprimé , le pays est lié à un circuit");
        } else {
            $manager->remove($country);
            $manager->flush();
            $this->addFlash("danger","{$country->getName()} a bien été supprimé ");
        }
        return $this->redirectToRoute("admin_country_index");
    }


    /**
     * @Route("/admin/city", name="admin_city_index")
     * @param ListingCityRepository $repo
     * @return Response
     */
    public function admin_city_index(ListingCityRepository $repo)
    {
        return $this->render('admin/other/city/index.html.twig',[
            'cities' => $repo->findAll()
        ]);
    }


    /**
     * @Route("/admin/city/create", name="admin_city_create")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function admin_city_create(EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
        $city = new ListingCity();
        $form = $this->createForm(CityType::class,$city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($city);
            $manager->flush();

            $this->addFlash("success","{$city->getName()} a bien été ajoutée");

            return $this->redirectToRoute('admin_city_index');
        }
        $breadcrumbs->prependRouteItem("Villes","admin_city_index")
                    ->addRouteItem("Création","admin_city_create");

        return $this->render('admin/other/city/create.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/city/{id}/edit", name="admin_city_edit")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param ListingCity $city
     * @return Response
     */
    public function admin_city_edit(EntityManagerInterface $manager,Request $request,ListingCity $city,Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(CityType::class,$city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($city);
            $manager->flush();

            $this->addFlash("info","{$city->getName()} a bien été modifiée ");

            return $this->redirectToRoute('admin_city_index');
        }

        $breadcrumbs->prependRouteItem("Villes","admin_city_index")
                    ->addRouteItem("Modification","admin_city_edit",['id'=> $city->getId()]);

        return $this->render('admin/other/city/edit.html.twig',[
            'form' => $form->createView(),
            'city' => $city
        ]);
    }

    
    /**
     * @Route("/admin/city/{id}/delete", name="admin_city_delete")
     * @param ListingCity $city
     * @param EntityManagerInterface $manager
     */
    public function admin_city_delete(ListingCity $city,EntityManagerInterface $manager)
    {
        if (count($city->getListing())) {
            $this->addFlash("warning","{$city->getName()} ne peut etre supprimée , la ville est liée à un circuit");
        } else {
            $manager->remove($city);
            $manager->flush();
            $this->addFlash("danger","{$city->getName()} a bien été supprimée ");
        }
        return $this->redirectToRoute("admin_city_index");
    }
}
