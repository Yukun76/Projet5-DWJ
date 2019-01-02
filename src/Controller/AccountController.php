<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends Controller
{

    /**
     * @Route("/profile", name="profile") 
     */
    public function profile() {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('account/profile.html.twig');
    }


    /**
     * @Route("/modification-du-mot-de-passe", name="mdp_change") 
     */
    public function mpdChange(request $request) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);  

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->request->get('profile')['oldPassword'];

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($newEncodedPassword);
                
                $em->persist($user);
                $em->flush();


                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('profile');

            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

         return $this->render('account/mdpChange.html.twig', [
            'form' => $form->createView(),
         ]);
    }


    /**
     * @Route("/mes-reservations", name="acc_reservation")
     */
    public function reservation() {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 

        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        $user = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $bookings = $repository->findBy(array(
            'user' => $user
        ));

        return $this->render('account/reservation.html.twig', [
            'bookings' => $bookings
        ]);
    }


    /**
     * @Route("/deleteReservation/{id}", name="del_reservation") 
     */
    public function delete(Booking $booking, ObjectManager $manager, $id) {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if($booking == NULL) {
            $booking = new Booking();
        };


        $repo = $this->getDoctrine()->getRepository(Booking::class);
        $booking = $repo->find($id);

        $manager->remove($booking);
        $manager->flush();

        return $this->redirectToRoute('acc_reservation');
    }

}