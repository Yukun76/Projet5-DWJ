<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PetlistController extends AbstractController
{
    /**
     * @Route("/petlist", name="petlist")
     */
    public function index()
    {
        return $this->render('petlist/index.html.twig', [
            'controller_name' => 'PetlistController',
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function list()
    {
        return $this->render('petlist/liste.html.twig');
    }
}
