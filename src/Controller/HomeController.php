<?php

namespace App\Controller;
use App\Entity\Ad;
use App\Entity\Animal;
use App\Form\SearchAnimalType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(request $request)
    {
        $searchAnimal = $request->get('animal');
        $search = $this->createForm(SearchAnimalType::class, $searchAnimal);  

        // $repo = $this->getDoctrine()->getRepository(Ad::class);
       // $ads = $repo->findAll();

        $repository = $this->getDoctrine()->getRepository(Animal::class);       

        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $critera = [];
            if (isset($searchAnimal['type']) && !empty($searchAnimal['type'])) {
                $critera['type'] = $searchAnimal['type'];
            }
            if (isset($searchAnimal['sexe']) && !empty($searchAnimal['sexe'])) {
                $critera['sexe'] = $searchAnimal['sexe'];
            }
            if (isset($searchAnimal['region']) && !empty($searchAnimal['region'])) {
                $critera['region'] = $searchAnimal['region'];
            }

            $animals = $repository->findBy($critera);  
        }


        return $this->render('home/search.html.twig', [
            'animals' => $animals,
            'search' => $search->createView(),
            //'ads' => $ads
        ]);
    }


    /**
     *   @Route("/", name="accueil")
     */
    public function accueil(request $request)
    {
        $search = $this->createForm(SearchAnimalType::class);        
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid() ) {

            return $this->redirectToRoute("search");
        }

        return $this->render('home/accueil.html.twig', [
            'search' => $search->createView(),
            'ads' => $ads            
        ]);
    }

    /**
     * @Route("/annonce/{id}", name="ad_show")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(ad::Class);

        $annonce = $repo->find($id);

        return $this->render('ad/show.html.twig',[
            'annonce' => $annonce,
        ]);
    }
}
