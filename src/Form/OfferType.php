<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description de l\'offre'
            ])
            ->add('startAt', DateType::class, [
                'required' => true,
                'label' => 'Date de début'
            ])
            ->add('endAt', DateType::class, [
                'required' => true,
                'label' => 'Date de fin'
            ])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'label' => 'Type',
                'choices' => [
                    'Ouvrier' => 'Ouvrier',
                    'Technicien' => 'Technicien',
                    'Projet fin d\'etude' => 'Projet fin d\'etude',
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
