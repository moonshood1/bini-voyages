<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function index(BlogRepository $blog_repo): Response
    {
        $articles = $blog_repo->findAll(); 
        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/blog/category/{id}", name="blog_index_category")
     * @param BlogRepository $blog_repo
     * @return Response
     */
    public function index_by_category(BlogRepository $blog_repo):Response
    {
        $articles = $blog_repo->findBy(['','id'=> 'DESC']);

        return $this->render('blog/index_by_category.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/blog/article/{id}", name="blog_show")
     * @param Blog $article
     */
    public function show(Blog $article)
    {
        return $this->render('blog/show.html.twig',[
            'article' => $article
        ]);
    }

    /**
     * PARTIE ADMINISTRATION 
    */

    /**
     * @Route("/admin/blog/{page<\d+>?1}", name="admin_blog_index")
     * @IsGranted("ROLE_ADMIN")
     * @param BlogRepository $blog_repo
     */
    public function admin_blog(PaginationService $pagination, $page)
    {
       $pagination = $pagination->setEntityClass(Blog::class)->setPage($page);
        return $this->render('admin/blog/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/blog/article/create", name="admin_article_create")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     */
    public function admin_article_create(EntityManagerInterface $manager,Request $request)
    {
        $article = new Blog();
        $form = $this->createForm(BlogType::class,$article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser());
            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success","L'article {$article->getTitle()} a bien été créé !");

            return $this->redirectToRoute("admin_blog_index");
        }

        return $this->render('admin/blog/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/blog/article/{id}/edit", name="admin_article_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Blog $article
     */
    public function admin_article_edit(EntityManagerInterface $manager,Request $request,Blog $article)
    {
        $form = $this->createForm(BlogType::class,$article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();

            $this->addFlash("info","L'article {$article->getTitle()} a bien été modifié !");

            return $this->redirectToRoute("admin_blog_index");
        }

        return $this->render('admin/blog/edit.html.twig',[
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/blog/article/{id}/delete", name="admin_article_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param EntityManagerInterface $manager
     * @param Blog $article
     * @return void
     */
    public function admin_article_delete(EntityManagerInterface $manager,Blog $article)
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash("danger","L'article {$article->getTitle()} a bien été supprimé !");

        $this->redirectToRoute("admin_blog_index");
    }

    /**
     * @Route("admin/blog/article/{id}/details", name="admin_article_show")
     * @IsGranted("ROLE_ADMIN")
     * @param Blog $article
     */
    public function admin_admin_show(Blog $article)
    {
        return $this->render('admin/blog/show.html.twig',[
            'article' => $article
        ]);
    }
}
