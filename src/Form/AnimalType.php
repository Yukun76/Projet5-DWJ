<?php

namespace App\Form;

use App\Entity\Animals;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, array(
            'choices' => array(
                '' => 'placeholder',
                'Chien' => 'chien',
                'Chat' => 'chat',
                'Autres espèces' => 'autre',
            ),
        ))
                ->add('sexe', ChoiceType::class, array(
            'choices' => array(
                '' => 'placeholder',
                'Mâle' => 'm',
                'Femelle' => 'f',
            ),
        ))
                ->add('region', ChoiceType::class, array(
            'choices' => array(
                '' => 'placeholder',
                'Auvergne-Rhône-Alpes' => 'ara',
                'Bourgogne-Franche-Comté' => 'bfc',
                'Bretagne'   => 'bre',
                'Centre-Val de Loire' => 'cvl',
                'Corse' => 'cor',
                'Grand Est : Alsace' => 'ges',
                'Hauts-de-France' => 'hdf',
                'Île-de-France' => 'idf',
                'Normandie' => 'nor',
                'Nouvelle-Aquitain' => 'naq',
                'Occitanie : Languedoc-Roussillon-Midi-Pyrénée' => 'occ',
                'Pays de la loire' => 'pdl',
                'Provence-Alpes-Côte d’Azur' => 'pac',
            ),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
        ]);
    }
}
