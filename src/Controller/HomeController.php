<?php

namespace App\Controller;

use App\Entity\Animals;
use App\Entity\Article;
use App\Form\AnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Forms;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     *   @Route("/", name="accueil")
     */

    public function accueil() {
        $animals = new Animals();
        $form = $this->createForm(AnimalType::class, $animals);

        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

                return $this->render('home/accueil.html.twig', [
                    'form' => $form->createView(),
                    'articles' => $articles
                ]);
    }
}
