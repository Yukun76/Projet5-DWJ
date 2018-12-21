<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/mes-reservations", name="acc_reservation")
     */
    public function reservation()
    {       

        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $booking = $repository->findOneBy(array(
            'ad' => $ads
        ));

        return $this->render('account/reservation.html.twig', [
            'booking' => $booking
        ]);
    }

    /**
     * @Route("/deleteReservation/{id}", name="del_reservation") 
     */

    public function delete(Booking $booking, ObjectManager $manager, $id) {

        $repo = $this->getDoctrine()->getRepository(Booking::class);
        $booking = $repo->find($id);

        $manager->remove($booking);
        $manager->flush();

        return $this->redirectToRoute('acc_reservation');
    }


    /**
     * @Route("/profile", name="profile") 
     */

    public function profile() {

         return $this->render('account/profile.html.twig');
    }
}