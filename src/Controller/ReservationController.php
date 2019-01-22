<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends Controller
{
   /**
     * @Route("/reserve/{id}", name="reservation_accepted")
     */
    public function reservationPopUp($id, request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {
    	$repo = $this->getDoctrine()->getRepository(Ad::class);
        $annonce = $repo->find($id);

        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {           
           
            if(!$booking->getId()){
                $booking->setCreatedAt(new \DateTime());
            }

            $user = $this->getUser();
            $booking->setUser($user);
      
            $booking->setAd($annonce);

            $manager->persist($booking);
            $manager->flush();

            //Envoie un mail de confirmation à l'utilisateur
            $email = $this->getUser()->getEmail();
            $username = $this->getUser()->getUsername();
            $pet = $annonce->getAnimal()->getName();


            $message = (new \Swift_Message('PetAdopt : Confirmation de la révervation'))
                ->setFrom('YuKunOCR@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'emails/reservation.html.twig',[ 
                        'username' => $username,
                        'annonce' => $annonce,
                        'name' => $pet
                        ]
                    ),                
                        'text/html'
                )
            ;

            $mailer->send($message);

            return $this->redirectToRoute('ad_show', ['id' => $annonce->getId()]);
        }

        return $this->render('reservation/index.html.twig',[
            'formBook' => $form->createView()
        ]);
    }
}
