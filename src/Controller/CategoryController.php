<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Category1Type;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $user = $this->getUser();
        if($user){
            return $this->render('category/index.html.twig', [
                'categories' => $categoryRepository->findAll(),
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        if($user){
            $category = new Category();
        $form = $this->createForm(Category1Type::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        $user = $this->getUser();
        if($user){
            return $this->render('category/show.html.twig', [
                'category' => $category,
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $user = $this->getUser();
        if($user){
            $form = $this->createForm(Category1Type::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
        }else{
            return $this->redirectToRoute('home');
        }
        
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category): Response
    {
        $user = $this->getUser();
        if($user){
            if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($category);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('category_index');
        }else{
            return $this->redirectToRoute('home');
        }
        
    }
}
