<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user_index")
     */
    public function admin_user_index(): Response
    {
        return $this->render('admin/user/index.html.twig', []);
    }

    /**
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     * @param EntityManagerInterface $manager
     */
    public function admin_user_delete(User $user,EntityManagerInterface $manager)
    {
        if (count($user->getBookings()) > 0) {
            $user->setIsActive(false);
            $this->addFlash('warning',"Vous ne pouvez pas supprimer cet utilisateur car il a des commandes, il sera donc désactivé");
        } else {
            $manager->remove($user);
            $manager->flush();
        }

        return $this->redirectToRoute("admin_user_index");
    }

    /**
     * @Route("/admin/user/{id}/details", name="admin_user_show")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     */
    public function admin_user_show(User $user)
    {
        return $this->render('admin/user/show.html.twig',[
            'user' => $user
        ]);
    }
}
