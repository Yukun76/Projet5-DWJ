<?php

namespace App\Controller;


use App\Entity\Ad;
use App\Form\AdType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;



class AdController extends AbstractController
{
    /**
     * @Route("/annonce/new", name="ad_new")
     * @Route("/annonce/{id}/edit", name="ad_edit")
     */
    public function form(Ad $annonce = null, request $request, ObjectManager $manager)
    {
        if(!$annonce) {
            $annonce = new Ad();
        }

        $form = $this->createForm(AdType::class, $annonce);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if(!$annonce->getId()){
                $annonce->setCreatedAt(new \DateTime());
            }

            $manager->persist($annonce);
            $manager->flush();

            return $this->redirectToRoute('annonce');
        }

        return $this->render('ad/create.html.twig', [
            'formAd' => $form->createView(),
            'edit' => $annonce->getId() !== null
        ]);
    }


    /**
     * @Route("/delete/{id}", name="del_ad") 
     *
     * @return Response
     */

    public function delete(Ad $annonce, ObjectManager $manager, $id) {

    	if($annonce == NULL) {
    		$annonce = new Ad();
    	};

		$repo = $this->getDoctrine()->getRepository(Ad::class);
        $annonce = $repo->find($id);

    	$manager->remove($annonce);
    	$manager->flush();

    	return $this->redirectToRoute('annonce');
    }
}