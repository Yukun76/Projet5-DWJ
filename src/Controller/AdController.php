<?php

namespace App\Controller;

use App\Entity\Ad;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Debug\handleRequest;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/article/new", name="ad_new")
     * @Route("/article/{id}/edit", name="ad_edit")
     */
    public function form(Ad $article = null, request $request, ObjectManager $manager)
    {
    	if(!$article) {
    		$article = new Ad();
    	}

    	$form = $this->createFormBuilder($article)
    				 ->add('title')
    				 ->add('content')
    				 ->add('image')
    				 ->getForm();

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()) {

    		if(!$article->getId()){
    			$article->setCreatedAt(new \DateTime());
    		}

    		$manager->persist($article);
    		$manager->flush();

    		return $this->redirectToRoute('ad_show', ['id' => $article->getId()]);
    	}

        return $this->render('ad/adCreate.html.twig', [
        	'formArticle' => $form->createView(),
        	'edit' => $article->getId() !== null
        ]);
    }
}
