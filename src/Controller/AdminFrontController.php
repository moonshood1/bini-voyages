<?php

namespace App\Controller;

use App\Entity\FrontPage;
use App\Entity\Guides;
use App\Form\FrontPageType;
use App\Form\GuidesType;
use App\Repository\GuidesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFrontController extends AbstractController
{
    /**
     * @Route("/admin/frontend", name="admin_frontend_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_frontend_index(FrontPage $front): Response
    {
        return $this->render('admin/front & guides/front/index.html.twig', [
            'front' => $front
        ]);
    }

    /**
     * @Route("/admin/frontend/edit", name="admin_frontend_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param FrontPage $front
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_frontend_edit(FrontPage $front,EntityManagerInterface $manager,Request $request)
    {
        $form = $this->createForm(FrontPageType::class,$front);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($front);
            $manager->flush();

            $this->addFlash('primary', "Le frontend a bien été modifié");

            return $this->redirectToRoute("admin_frontend_index");
        }

        return $this->render('admin/front & guides/front/edit.html.twig',[
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
        return $this->render('admin/front & guides/guides/index.html.twig',[
            'guides' => $guides_repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/guides/create", name="admin_guides_create")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_guides_create(EntityManagerInterface $manager,Request $request)
    {
        $guide = new Guides();
        $form = $this->createForm(GuidesType::class,$guide);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($guide);
            $manager->flush();

            $this->addFlash('success',"Le guide <strong> {$guide->getGuideName()} a bien été créé !");
            return $this->redirectToRoute("admin_guides_index");
        }

        return $this->render('admin/front & guides/guides/create.html.twig');
    }

    /**
     * @Route("/admin/guides/{id}/edit", name="admin_guides_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_guides_edit(Guides $guide,EntityManagerInterface $manager,Request $request)
    {
         $form = $this->createForm(GuidesType::class,$guide);
         $form->handleRequest($request);
         
         if ($form->isSubmitted() && $form->isValid()) {
             $manager->persist($guide);
             $manager->flush();

             $this->addFlash('primary',"Le guide <strong> {$guide->getGuideName()} a bien été modifié !");
             return $this->redirectToRoute("admin_guides_index");
        }
        
        return $this->render('admin/front & guides/guides/edit.html.twig');
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

        $this->addFlash('warning',"Le guide <strong> {$guide->getGuideName()} a bien été retiré de la liste des guides !");
        return $this->redirectToRoute("admin_guides_index");
    }
}
