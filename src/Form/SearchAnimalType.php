<?php

namespace App\Form;
use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->setAction('search')
                ->setMethod('GET')
                ->add('type', ChoiceType::class, array(

            'required' => false,
            'choices' => array(
                'Chien' => 'chien',
                'Chat' => 'chat',
                'Autres espèces' => 'autre',
            ),
        ))
                ->add('sexe', ChoiceType::class, array(
            'required' => false,
            'choices' => array(
                'Mâle' => 'm',
                'Femelle' => 'f',
            ),
        ))
                ->add('region', ChoiceType::class, array(
            'required' => false,
            'choices' => array(
                'Auvergne-Rhône-Alpes' => '1',
                'Bourgogne-Franche-Comté' => '2',
                'Bretagne'   => '3',
                'Centre-Val de Loire' => '4',
                'Corse' => '5',
                'Grand Est : Alsace' => '6',
                'Hauts-de-France' => '7',
                'Île-de-France' => '8',
                'Normandie' => '9',
                'Nouvelle-Aquitaine' => '10',
                'Occitanie : Languedoc-Roussillon-Midi-Pyrénée' => '11',
                'Pays de la loire' => '12',
                'Provence-Alpes-Côte d’Azur' => '13',
            ),
        ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Lancer la recherche',
                    'attr' => ['class' => 'btn-success']
                ))

        ;
    }


  /*  public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class' => Animal::class,
        ]);
    }
 */
}
