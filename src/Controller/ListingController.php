<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Listing;
use App\Entity\ListingImage;
use App\Form\BookingType;
use App\Form\ListingType;
use App\Repository\ListingRepository;
use App\Services\Cart\CartService;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListingController extends AbstractController
{
    /**
     * @Route("/listing", name="user_listing_index")
     */
    public function user_listing_index(ListingRepository $listing_repo): Response
    {
        return $this->render('listing/index.html.twig', [
            'listings' => $listing_repo->findAll()
        ]);
    }

    public function user_listing_recap()
    {
        // Fonction ou on affiche le recap de ce qu'il vient de commander (En gros c'est le panier avec un autre nom)
    }

    public function user_listing_book(CartService $cartService,Request $request)
    {
        $session = $request->getSession();
        // Fonction ou on entre les données comme le numéro a contacter ou le commentaire sur la reservation et la quantité
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $session->set('phoneNumber',$request->request->get('listing')['phoneNumber']);
            $session->set('comment',$request->request->get('listing')['comment']);
        }
    }

    public function user_listing_checkout_success(EntityManagerInterface $manager,Request $request,CartService $cartService)
    {
        $booking = new Booking();
        $booking->setBooker($this->getUser())
                ->setInvoiceNumber(substr(strtoupper(md5(date('Y-m-d h:i:s'))),0,-15))
                ->setListing($cartService->getFullCart()[0]['listing'])
                ->setAmount($cartService->getTotal());

        $this->addFlash('success',"Votre réservation a bien été enregistrée! Vous recevrez un mail récapitulatif");        

        $manager->persist($booking);
        $manager->flush();

    }

    public function user_listing_checkout_failed()
    {
        // Fonction echec du checkout
    }

    /**
     * @Route("/listing/{id}/details", name="user_listing_show")
     * @param Listing $listing
     */
    public function user_listing_show(Listing $listing)
    {
        return $this->render('listing/show.html.twig',[
            'listing' => $listing
        ]);
    }
    
    


    /**
     * PARTIE ADMINISTRATION
     */


    /**
     * @Route("/admin/listing/{page<\d+>?1}", name="admin_listing_index")
     * @IsGranted("ROLE_ADMIN")
     * @param ListingRepository $listing_repo
     */
    public function admin_listing_index(PaginationService $pagination,$page)
    {
        $pagination->setEntityClass(Listing::class)->setPage($page);

        return $this->render('admin/listing/index.html.twig',[
            'pagination' => $pagination
        ]);
    } 

    /**
     * @Route("/admin/listing/all", name="admin_listing_show_all")
     * @param ListingRepository $listing_repo
     */
    public function admin_listing_show_all(ListingRepository $listing_repo)
    {
        return $this->render('admin/listing/show_all.html.twig',[
            'listings' => $listing_repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/listing/create", name="admin_listing_create")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function admin_listing_create(EntityManagerInterface $manager,Request $request)
    {
        $listing = new Listing();
        $form = $this->createForm(ListingType::class,$listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($listing->getImages() as $image) {
                $image->SetListing($listing);
                $manager->persist($image);
            }

            $listing->setAuthor($this->getUser());
            $manager->persist($listing);
            $manager->flush();

            $this->addFlash('success',"Le circuit {$listing->getTitle()} a bien été créé !" );
            return $this->redirectToRoute("admin_listing_index");
        }

        return $this->render('admin/listing/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/listing/{id}/edit", name="admin_listing_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Listing $listing
     * @return Response
     */
    public function admin_listing_edit(EntityManagerInterface $manager,Request $request,Listing $listing)
    {
        $form = $this->createForm(ListingType::class,$listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($listing->getImages() as $image) {
                $image->SetListing($listing);
                $manager->persist($image);
            }

            $manager->persist($listing);
            $manager->flush();

            $this->addFlash('success',"Le circuit {$listing->getTitle()} a bien été créé !" );
            return $this->redirectToRoute("admin_listing_index");
        }

        return $this->render('admin/listing/edit.html.twig',[
            'form' => $form->createView(),
            'listing' => $listing
        ]);
    }

    /**
     * @Route("/admin/listing/{id}/delete", name="admin_listing_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Listing $listing
     */
    public function admin_listing_delete(EntityManagerInterface $manager,Listing $listing)
    {
        if (count($listing->getBookings()) > 0) {
            $this->addFlash('Warning',"Le circuit {$listing->getTitle()} a bien été desactivé !");
            $listing->setIsOpen(false);
        } else {
            $this->addFlash('Warning',"Le circuit {$listing->getTitle()} a bien été supprimé !");
            $manager->remove($listing);
            $manager->flush();
        }

        return $this->redirectToRoute("admin_listing_index");
    }

    /**
     * @Route("/admin/listing/{id}/details", name="admin_listing_show")
     * @IsGranted("ROLE_ADMIN")
     * @param Listing $listing
     */
    public function admin_listing_show(Listing $listing)
    {
        return $this->render('admin/listing/show.html.twig',[
            'listing' => $listing
        ]);
    }
}
