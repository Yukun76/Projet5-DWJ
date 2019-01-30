<?php

namespace App\Controller;

use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

use App\Entity\User;
use App\Form\EmailForForgotPasswordType;
use App\Form\NewPasswordType;


class ForgotPasswordController extends Controller
{
    /**
     * @Route("/demande-changement-de-mot-de-passe", name="forgot_password")
     */
    public function sendEmailNewPwd(Request $request, Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $form = $this->createForm(EmailForForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(User::class)->findOneByEmail($form->getData()['email']);

            // aucun email associé à ce compte.
            if (!$user) {
                $request->getSession()->getFlashBag()->add('warning', "Cet email n'existe pas.");
                return $this->redirectToRoute("forgot_password");
            } 

            // création du token
            $user->setToken($tokenGenerator->generateToken());
            // enregistrement de la date de création du token
            $user->setPasswordRequestedAt(new \Datetime());
            $em->flush();

            // on utilise le service Mailer
            $bodyMail = $mailer->createBodyMail('emails/resetMdp.html.twig', [
                'user' => $user
            ]);
            
            $mailer->sendMessage(
                'from@email.com', $user->getEmail(),
                'PetAdopt: Renouvellement du mot de passe',
                 $bodyMail
            );

            $request->getSession()->getFlashBag()->add('success_mail', "Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe. Le lien que vous recevrez sera valide 24h.");

            return $this->redirectToRoute("login");
        }

        return $this->render('forgotPwd/request.html.twig', [
            'form' => $form->createView()
        ]);
    }
 
    // si supérieur à 10min, retourne false
    // sinon retourne false
    private function emailTimeValid(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {
            return false;        
        }
        
        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;
        return $response;
    }

    /**
     * @Route("nouveau-mot-de-passe/{id}/{token}", name="resetting")
     */
    public function newPwd(User $user, $token, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        
        // interdit l'accès à la page si:
        // le token associé au membre est null
        // le token enregistré en base et le token présent dans l'url ne sont pas égaux
        // le token date de plus de 10 minutes
        if ($user->getToken() === null || $token !== $user->getToken() || !$this->emailTimeValid($user->getPasswordRequestedAt()))
        {
            throw new AccessDeniedHttpException();
        }

        $form = $this->createForm(NewPasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($newEncodedPassword);

            // réinitialisation du token et de la date de sa création à NULL
            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success_new', "Votre mot de passe a été renouvelé.");

            return $this->redirectToRoute('login');

        }

        return $this->render('forgotPwd/index.html.twig', [
            'form' => $form->createView()
        ]);        
    }
}
