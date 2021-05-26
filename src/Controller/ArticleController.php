<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\SearchByTitle;
use App\Form\SearchByTitleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET","POST"})
     */
    public function index(ArticleRepository $articleRepository,  Request $request): Response
    {
        $user = $this->getUser();
        if($user){
            $SearchByTitle = new SearchByTitle();
        $form = $this->createForm(SearchByTitleType::class, $SearchByTitle);
        $form->handleRequest($request);
        $articles=[];
        if ($form->isSubmitted() && $form->isValid()) {
            $title = $SearchByTitle->getTitle();
            if ($title!="") {
                //si on a fourni un matricule d'automobile on affiche tous les automobiles ayant ce matricule
                $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(['title'=>$title]);
            } else {
                //si si aucun nom n'est fourni on affiche tous les automobiles
                $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
            }
            return $this->render('article/index.html.twig', [ 'formSearch' =>$form->createView(),
             'articles'=>$articles]);
            
        }else{
            $articles= $articleRepository->findAll();
            return $this->render('article/index.html.twig', ['formSearch' =>$form->createView(),
            'articles' => $articles
        ]);

        }
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        if($user){
            $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //to upload the image
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_directory'), $fileName);
            $article->setImage($fileName);
            $article = $form->getData();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        $user = $this->getUser();
        if($user){
            return $this->render('article/show.html.twig', [
                'article' => $article,
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $user = $this->getUser();
        if($user){
            $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        $user = $this->getUser();
        if($user){
            if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($article);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('article_index');
        }else{
            return $this->redirectToRoute('home');
        }
        
    }
}
