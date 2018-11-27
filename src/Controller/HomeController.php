<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Ad;
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
        $form = $this->createForm(AnimalType::class);

        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        return $this->render('home/accueil.html.twig', [
            'form' => $form->createView(),
            'ads' => $ads
        ]);
    }
}
