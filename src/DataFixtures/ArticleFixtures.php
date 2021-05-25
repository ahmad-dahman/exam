<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        //creer 3 categories
        for($i=1;$i<3;$i++){
            $category= new Category();
            $category->setTitle($faker->sentence()); 
                    // ->setdescription($faker->paragraph());
             $manager->persist($category);     
             
             $manager->flush();


        




        }
    }

}


    // for($j = 1; $j <= mt_rand(4,6); $j++){
              //  $article =new Article();
                //$article->setTitle($faker->sentence())
                  //      ->setContent("<p>Contenue de l'article n °$j</p>")
                    //    ->setImage("http://placehold.it/350x150")
                      //  ->setCreatedAt(new \DateTime());  
                        //-setCategory($category);
    
              //  $manager->persist($article);
            //4
        //}  
       // }