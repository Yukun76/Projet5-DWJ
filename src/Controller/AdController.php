<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

use App\Entity\Ad;
use App\Form\AdType;
use App\Service\FileUploader;

 /**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMIN")
  */ 
class AdController extends AbstractController
{
    /** 
     * @Route("/annonce/new", name="ad_new")
     * @Route("/annonce/{id}", name="ad_edit")
     */
    public function form(Ad $annonce = null, request $request, FileUploader $fileUploader, ObjectManager $manager)
    {
      if(!$annonce) {
          $annonce = new Ad();
      } else {
            $annonce->setImage(
                new File($this->getParameter('animals_directory').'/'.$annonce->getImage())
            );
      }
        
        $form = $this->createForm(AdType::class, $annonce);        
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $file = $annonce->getImage();
            $fileName = $fileUploader->upload($file);

            $annonce->setImage($fileName);

            if(!$annonce->getId()){
                $annonce->setCreatedAt(new \DateTime());
            }

            $manager->persist($annonce);
            $manager->flush();

            $this->addFlash('notice', 'Annonce ajoutée avec succès !');

            return $this->redirectToRoute('annonce');
        }


        return $this->render('admin/ad/create.html.twig', [
            'formAd' => $form->createView(),
            'edit' => $annonce->getId() !== null
        ]);
    }

    /**
     * @Route("/delete/{id}", name="del_ad") 
     */
    public function delete(Ad $annonce, ObjectManager $manager, $id)
    {
    	$manager->remove($annonce);
    	$manager->flush();

      $this->addFlash('notice_del', 'L\'annonce a été supprimée avec succès !');

    	return $this->redirectToRoute('annonce');
    }
}