<?php

namespace App\Controller;

use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Ad;
use App\Entity\Animal;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Form\SearchAnimalType;

class HomeController extends Controller
{

    /**
     * @Route("/", name="accueil")
     */
    public function accueil(request $request)
    {
        $animal = new Animal;
        $search = $this->createForm(SearchAnimalType::class, $animal);  
              
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAllAdExceptBooking();

        /**
         * @var $paginator \Knp Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $ads,
            $request->query->getInt('page', 1),
            3
        );

        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid() ) {
            return $this->redirectToRoute("search");
        }

        return $this->render('home/accueil.html.twig', [
            'search' => $search->createView(),
            'ads' => $result,
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(request $request)
    {   
        $searchAnimal = $request->get('search_animal');
        $search = $this->createForm(SearchAnimalType::class, $searchAnimal);  

        $repo = $this->getDoctrine()->getRepository(Ad::class);

        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $type = $searchAnimal['type'] ?? null;
            $sexe = $searchAnimal['sexe'] ?? null;
            $region = $searchAnimal['region'] ?? null;

            $ads = $repo->findAdWithSearch($type, $sexe, $region);
        } 

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $ads,
            $request->query->getInt('page', 1),
            3
        );     

        return $this->render('home/search.html.twig', [
            'ads' => $result,
            'search' => $search->createView(),
            'type' => $type
        ]);
    }


    /**
     * @Route("/annonce/{id}", name="ad_show")
     */
    public function information(int $id, request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $annonce = $repo->find($id);

        $form = $this->createForm(BookingType::class, $annonce);

        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $bookings = $repository->findBy(array(
            'ad' => $annonce
        ));

        if (!$annonce) {
            throw $this->createNotFoundException(
                "Aucune annonce n'a été trouvée pour l'id ".$id
            );
        }

        $this->container->get('session')->set('announce', $annonce->getId());

        $form->handleRequest($request);       

        return $this->render('infoAnnonce/information.html.twig',[
            'annonce' => $annonce,
            'bookings' => $bookings,
            'formBook' => $form->createView()
        ]);
    }
    

    /**
     * @Route("/contact", name="admin_contact")
     */
    public function contact()
    {   
        return $this->render('contact/contact.html.twig');
    }
}
