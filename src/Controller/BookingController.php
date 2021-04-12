<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Services\Pagination\PaginationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="user_booking_index")
     * @IsGranted("ROLE_USER")
     */
    public function user_booking_index(BookingRepository $booking_repo): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $booking_repo->findBy(['booker'=> $this->getUser()])
        ]);
    }

    // Pour plus tard
    public function admin_booking_validate(){}

    public function user_booking_recap()
    {
        
    }

    /**
     * @Route("/admin/booking/{page<\d+>?1}", name="admin_booking_index")
     * @IsGranted("ROLE_ADMIN")
     * @param BookingRepository $booking_repo
     */
    public function admin_booking_index(PaginationService $pagination, $page)
    {
        $pagination->setEntityClass(Booking::class)->setPage($page);
        return $this->render('admin/booking/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    /**
     * 
     */
    public function amdin_booking_delete(){}


    /**
     * @Route("/admin/booking/all", name="admin_booking_show_all")
     * @param BookingRepository $booking_repo
     */
    public function admin_booking_all(BookingRepository $booking_repo)
    {
        return $this->render('admin/booking/show_all.html.twig',[
            $booking_repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/booking/{id}/details", name="admin_booking_show")
     * @IsGranted("ROLE_ADMIN")
     * @param Booking $booking
     */
    public function admin_booking_show(Booking $booking)
    {   
        return $this->render('admin/booking/show.html.twig',[
            'booking' => $booking
        ]);
    }

}
