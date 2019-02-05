<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;

class ReservationController extends Controller
{
   /**
     * @Route("/reserve/{id}", name="reservation_accepted")
     */
    public function reservationPopUp(Ad $annonce, request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {               
            $booking = (New Booking())   
                ->setCreatedAt(new \DateTime())
                ->setUser($this->getUser())      
                ->setAd($annonce);

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

            return new Response('');
        }
    }
