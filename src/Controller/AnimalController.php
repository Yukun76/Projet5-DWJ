<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Debug\handleRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Animal;
use App\Form\AnimalType;

 /**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMIN")
  */
class AnimalController extends AbstractController
{
    /**
     * @Route("/animal/new", name="pet_new")
     * @Route("/animal/{id}", name="pet_edit")
     */
    public function form(Animal $animal = null, request $request, ObjectManager $manager)
    {
    	if(!$animal) {
    		$animal = new Animal();
    	}

    	$form = $this->createForm(AnimalType::class, $animal);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()) {

    		$manager->persist($animal);
    		$manager->flush();

        $this->addFlash('notice', 'Animal ajouté avec succès !');

    		return $this->redirectToRoute('animal');
    	}

        return $this->render('admin/animal/create.html.twig', [
        	'formAnimal' => $form->createView(),
        	'edit' => $animal->getId() !== null
        ]);
    }
    

    /**
     * @Route("/deleteAnimal/{id}", name="del_pet") 
     */
    public function delete(Animal $animal, ObjectManager $manager, $id)
    {
        $manager->remove($animal);
        $manager->flush();

        $this->addFlash('notice_del', 'L\'animal a été supprimé avec succès !');

        return $this->redirectToRoute('animal');
    }
}
