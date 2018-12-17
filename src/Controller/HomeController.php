<?php

namespace App\Controller;
use App\Entity\Ad;
use App\Entity\Animal;
use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use App\Form\SearchAnimalType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{

    /**
     *   @Route("/", name="accueil")
     */
    public function accueil(request $request)
    {
        $search = $this->createForm(SearchAnimalType::class);        
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

    /**
     *  @var $paginator \Knp Component\Pager\Paginator
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
     * @Route("/information/{id}", name="ad_show")
     */
    public function show(int $id, request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $annonce = $repo->find($id);

        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
           

            $manager->persist($booking);
            $manager->flush();

            //Envoie un mail de confirmation à l'utilisateur
            $email = $form->get('email')->getData();
            $user = $form->get('firstname')->getData();
            $pet = $annonce->getAnimal()->getName();


            $message = (new \Swift_Message('PetAdopt : Confirmation de la révervation'))
                ->setFrom('YuKunOCR@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'emails/reservation.html.twig',[ 
                        'firstname' => $user,
                        'annonce' => $annonce,
                        'name' => $pet
                        ]
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);

            return $this->redirectToRoute("accueil");
        }

        return $this->render('ad/show.html.twig',[
            'annonce' => $annonce,
            'formBook' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/contact", name="admin_contact")
     */

    public function contact()
    {   
        return $this->render('contact/contact.html.twig');
    }
}
