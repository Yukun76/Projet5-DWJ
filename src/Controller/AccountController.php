<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\User;
use App\Form\ProfileType;

 /**
  * Require ROLE_USER for *every* controller method in this class.
  *
  * @IsGranted("ROLE_USER")
  */
class AccountController extends AbstractController
{
    private $encoder;

    /**
     * @Route("/profile", name="profile") 
     */
    public function profile() {

        return $this->render('account/profile.html.twig');
    }


    /**
     * @Route("/modification-du-mot-de-passe", name="mdp_change") 
     */
    public function mpdChange(request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);  
        $oldPassword = $request->request->get('profile')['oldPassword'];
        $passwordValid = $encoder->isPasswordValid($user, $oldPassword);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            // Si l'ancien mot de passe est bon
            if ($passwordValid === true) {

                $newEncodedPassword = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($newEncodedPassword);
                
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('notice', 'Votre mot de passe a bien été changé !');

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
    public function reservation() 
    {
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
    public function delete(Booking $booking, ObjectManager $manager, $id)
    {
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash('notice_del', 'La réservation a été annulée avec succès !');

        return $this->redirectToRoute('acc_reservation');
    }
}