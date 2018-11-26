<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

 /**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMIN")
  */
class AdminController extends AbstractController
{
    /**
     * Require ROLE_ADMIN for only this controller method.
     *
     * @IsGranted("ROLE_ADMIN")
     *
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

	    // or add an optional message - seen by developers
	    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/moderation", name="moderation")
     */
    public function moderation()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('admin/moderation.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function utilisateurs()
    {


        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        return $this->render('admin/utilisateurs.html.twig', [
            'users' => $users
        ]);
    }

}
