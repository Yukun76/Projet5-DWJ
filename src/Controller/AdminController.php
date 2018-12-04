<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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

    /**
     * @Route("/article", name="article")
     */
    public function article() 
    {    
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();  

        return $this->render('admin/article.html.twig', [
            'ads' => $ads            
        ]);
    }

}
