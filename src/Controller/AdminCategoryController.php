<?php

namespace App\Controller;

use App\Entity\BlogCategory;
use App\Entity\ListingCategory;
use App\Form\BlogCategoryType;
use App\Form\ListingCategoryType;
use App\Repository\BlogCategoryRepository;
use App\Repository\ListingCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="admin_category_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_category_index(BlogCategoryRepository $blog_repo, ListingCategoryRepository $listing_repo): Response
    {
        return $this->render('admin/category/index.html.twig',[
            'blog_cat' => $blog_repo->findAll(),
            'listing_cat' => $listing_repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/category/blog/create", name="admin_category_blog_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_blog_category_create(EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
        $cat = new BlogCategory();

        $form = $this->createForm(BlogCategoryType::class,$cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($cat);
            $manager->flush();

            $this->addFlash('success',"La catégorie {$cat->getTitle()} a bien été créée !");

            return $this->redirectToRoute("admin_category_index");
        }

        $breadcrumbs->prependRouteItem("Catégories", "admin_category_index")
                    ->addRouteItem("Création","admin_category_blog_create");

        return $this->render('admin/category/blog/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/blog/{id}/edit", name="admin_category_blog_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_blog_category_edit(EntityManagerInterface $manager,Request $request, BlogCategory $cat,Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(BlogCategoryType::class,$cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($cat);
            $manager->flush();

            $this->addFlash('info',"La catégorie {$cat->getTitle()} a bien été modifiée !");

            return $this->redirectToRoute("admin_category_index");
        }

        $breadcrumbs->prependRouteItem("Catégories", "admin_category_index")
                ->addRouteItem("Modification","admin_category_blog_edit",['id'=> $cat->getId()]);

        return $this->render('admin/category/blog/edit.html.twig',[
            'cat' => $cat,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/blog/{id}/delete", name="admin_category_blog_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_blog_category_delete(EntityManagerInterface $manager,BlogCategory $cat)
    {
        if (count($cat->getBlog()) > 0 ) {
            $this->addFlash('danger',"La catégorie {$cat->getTitle()} ne peut être supprimée !");
        } else {
            $manager->remove($cat);
            $manager->flush();  
                 
            $this->addFlash('danger',"La catégorie {$cat->getTitle()} a bien été supprimée !");

            return $this->redirectToRoute("admin_category_index");
        }    
        return $this->render("admin_category_index");
    }

    /**
     * @Route("/admin/category/listing/create", name="admin_category_listing_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_listing_category_create(EntityManagerInterface $manager,Request $request,Breadcrumbs $breadcrumbs)
    {
        $cat = new ListingCategory();
        $form = $this->createForm(ListingCategoryType::class,$cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($cat);
            $manager->flush();

            $this->addFlash('success',"La catégorie {$cat->getTitle()} a bien été créée !");

            return $this->redirectToRoute("admin_category_index");
        }

        $breadcrumbs->prependRouteItem("Catégories", "admin_category_index")
                ->addRouteItem("Création","admin_category_listing_create");
            
        return $this->render('admin/category/listing/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/category/listing/{id}/edit", name="admin_category_listing_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_listing_category_edit(EntityManagerInterface $manager,Request $request,ListingCategory $cat,Breadcrumbs $breadcrumbs)
    {
        $form = $this->createForm(ListingCategoryType::class,$cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($cat);
            $manager->flush();

            $this->addFlash('info',"La catégorie {$cat->getTitle()} a bien été modifiée !");

            return $this->redirectToRoute("admin_category_index");
        }

        $breadcrumbs->prependRouteItem("Catégories", "admin_category_index")
                ->addRouteItem("Modification","admin_category_listing_edit",['id'=> $cat->getId()]);

        return $this->render('admin/category/listing/edit.html.twig',[
            'cat'=> $cat,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/category/listing/{id}/delete", name="admin_category_listing_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param ListingCategory $cat
     */
    public function admin_listing_category_delete(EntityManagerInterface $manager,ListingCategory $cat)
    {
        if (count($cat->getListing()) > 0 ) {
            $this->addFlash('danger',"La catégorie {$cat->getTitle()} ne peut être supprimée !");
        } else {
            $manager->remove($cat);
            $manager->flush();       
            $this->addFlash('danger',"La catégorie {$cat->getTitle()} a bien été supprimée !");

            return $this->redirectToRoute("admin_category_index");
        }

        return $this->redirectToRoute("admin_category_index");
    }
}
