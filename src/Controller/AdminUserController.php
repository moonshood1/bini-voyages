<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user/{page<\d+>?1}", name="admin_user_index")
     */
    public function admin_user_index(PaginationService $pagination, $page): Response
    {
        $pagination->setEntityClass(User::class)->setPage($page);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination
        ]);
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
            $this->addFlash('danger',"L'utilisateur {$user->getLastName()} a bien été supprimé");
            $manager->flush();
        }

        return $this->redirectToRoute("admin_user_index");
    }

    /**
     * @Route("/admin/user/{id}/details", name="admin_user_show")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     */
    public function admin_user_show(User $user,Breadcrumbs $breadcrumbs)
    {
        $role = $user->getUserRoles()[0];

        $name = $user->getFirstName().' '.$user->getLastName();

        $breadcrumbs->prependRouteItem("Utilisateurs", "admin_user_index")
                    ->addRouteItem($name,"admin_user_show",['id'=> $user->getId()]);

        return $this->render('admin/user/show.html.twig',[
            'user' => $user,
            'role' => $role
        ]);
    }

    /**
     * @Route("/admin/user/all", name="admin_user_show_all")
     * @param UserRepository $user_repo
     */
    public function amdin_user_show_all(UserRepository $user_repo)
    {
        return $this->render("admin/user/show_all.html.twig",[
            'users' => $user_repo->find
        ]);
    }
}
