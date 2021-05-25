<?php

namespace App\Controller;
use App\Entity\Article;


use Doctrine\ORM\EntityManagerInterface;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticleType;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */

    public function home(){
        return $this->render('home.html.twig');//appeler le fichier twig pour pouvoir l'afficher
    }
   
}
