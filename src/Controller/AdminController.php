<?php

namespace App\Controller;

use Doctrine\ORM\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

use App\Entity\Ad;
use App\Entity\Animal;
use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use App\Form\SearchAnimalType;


 /**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @Security("has_role('ROLE_ADMIN')")
  */
class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(AuthorizationCheckerInterface $authChecker)
    {
    	if (false === $authChecker->isGranted('ROLE_ADMIN')) {
        throw new AccessDeniedException('Unable to access this page!');
    }

	    // or add an optional message - seen by developers
	    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        return $this->render('admin/index.html.twig');
    }


    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function utilisateurs(request $request)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

        /**
         *  @var $paginator \Knp Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        ); 

        return $this->render('admin/utilisateurs.html.twig', [
            'users' => $result
        ]);
    }
    

    /**
     * @Route("/annonce", name="annonce")
     */
    public function annonce(request $request) 
    {    
        $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll(); 

        /**
         *  @var $paginator \Knp Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $ads,
            $request->query->getInt('page', 1),
            3
        ); 

        return $this->render('admin/ad/annonce.html.twig', [
            'ads' => $result            
        ]);
    }


    /**
     * @Route("/animal", name="animal")
     */
    public function animal(request $request) 
    {    
        $searchAnimal = $request->get('search_animal');
        $search = $this->createForm(SearchAnimalType::class, $searchAnimal);  

        $repository = $this->getDoctrine()->getRepository(Animal::class); 
        $animals = $repository->findAll(); 

        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $critera = [];
            if (isset($searchAnimal['type']) && !empty($searchAnimal['type'])) {
                $critera['type'] = $searchAnimal['type'];
            }
            if (isset($searchAnimal['sexe']) && !empty($searchAnimal['sexe'])) {
                $critera['sexe'] = $searchAnimal['sexe'];
            }
            if (isset($searchAnimal['region']) && !empty($searchAnimal['region'])) {
                $critera['region'] = $searchAnimal['region'];
            }

            $animals = $repository->findBy($critera);  
        }

        /**
         *  @var $paginator \Knp Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $animals,
            $request->query->getInt('page', 1),
            3
        ); 

        return $this->render('admin/animal/animal.html.twig', [
            'animals' => $result,
            'search' => $search->createView(),           
        ]);
    }


    /**
     * @Route("/reservation", name="reservation")
     */
    public function reservation(request $request) 
    {    
        $repo = $this->getDoctrine()->getRepository(Booking::class);
        $bookings = $repo->findAll(); 

        /**
         *  @var $paginator \Knp Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $bookings,
            $request->query->getInt('page', 1),
            10
        ); 
        
        return $this->render('admin/reservation.html.twig', [
            'bookings' => $result, 
        ]);
    }
}
