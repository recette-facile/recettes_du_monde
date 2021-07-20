<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\ZoneGeo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomRecette')
            ->add('tempsPreparation')
            ->add('tempsCuisson')
            ->add('descriptionRecette')
            ->add('zoneGeo', EntityType::class, [
                'label' => 'cuisine typique de',
                'placeholder' => '-- choisir une zone géographique  --',
                'choice_label' => 'nom',
                'class' => ZoneGeo::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
