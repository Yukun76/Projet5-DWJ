<?php

namespace App\Controller;

use App\Controller\HomeController;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/inscription", name="registration")
	 */

	public function registration(request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder ) {

		$user = new User();
		$form = $this->createForm(RegistrationType::class, $user);

		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()) {

			$hash = $encoder->encodePassword($user, $user->getPassword());
			$user->setPassword($hash);

			$manager->persist($user);
			$manager->flush();

			return $this->redirectToRoute("login");
		}

		return $this->render('security/registration.html.twig', [
			'form' => $form->createView()
		]);
	}


	/**
	 * @Route("/connexion", name="login")
	 */

	public function login(Session $session, AuthenticationUtils $authenticationUtils): Response
	{
		// get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
	}


	/**
	 * @Route("/deconnexion", name="logout")
	 */

	public function logout(){}

}