<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Animal;
use App\Form\SearchAnimalType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('name')
            ->add('region')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
