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
                'Auvergne-Rhône-Alpes' => 'ara',
                'Bourgogne-Franche-Comté' => 'bfc',
                'Bretagne'   => 'bre',
                'Centre-Val de Loire' => 'cvl',
                'Corse' => 'cor',
                'Grand Est : Alsace' => 'ges',
                'Hauts-de-France' => '1',
                'Île-de-France' => 'idf',
                'Normandie' => 'nor',
                'Nouvelle-Aquitain' => 'naq',
                'Occitanie : Languedoc-Roussillon-Midi-Pyrénée' => 'occ',
                'Pays de la loire' => 'pdl',
                'Provence-Alpes-Côte d’Azur' => 'pac',
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
