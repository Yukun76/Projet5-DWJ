<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\RegistrationType;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/inscription", name="registration")
	 */
	public function registration(request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) 
	{
		$user = new User();
		$form = $this->createForm(RegistrationType::class, $user);

		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()) {

			$hash = $encoder->encodePassword($user, $user->getPassword());
			$user->setPassword($hash);

			$manager->persist($user);
			$manager->flush();

			$user = // Gère l'obtention ou la création de l'entité utilisateur avec un formulaire.
	        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
	        $this->container->get('security.token_storage')->setToken($token);
	        $this->container->get('session')->set('_security_main', serialize($token));	        
	        $annonceId = $this->container->get('session')->remove('announce');
	        // L'utilisateur est maintenant connecté, il peut maintenant être rédirigé.

	        if ($annonceId) {
	        	return $this->redirectToRoute('ad_show', ['id' => $annonceId]);
	        }

			return $this->redirectToRoute("accueil");
		}

		return $this->render('security/registration.html.twig', [
			'form' => $form->createView()
		]);
	}


	/**
	 * @Route("/connexion", name="login")
	 */
	public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
	{
		// Obtient l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        $targetPath = "/";
        $referer = $request->headers->get('referer');


        if (false !== strstr($referer, 'annonce')) {
        	$targetPath = $referer;
        }

		return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'targetPath' => $targetPath
        ]);
	}


	/**
	 * @Route("/deconnexion", name="logout")
	 */
	public function logout(){}

}