<?php

namespace App\Form;

use App\Entity\Party;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la partie',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('partyAt', DateTimeType::class, [
                'label' => 'Date et heure de la partie',
                'required' => true,
            ])
            ->add('localization', TextType::class, [
                'label' => "Lieu de la partie",
                'required' => true,
            ])
            ->add('expireAt', DateTimeType::class, [
                'label' => 'Expiration des inscriptions',
                'required' => true,
            ])
            ->add('cautionPrice', MoneyType::class, [
                'label' => "Prix de la caution",
                'required' => false,
                'data' => 50,
                'currency' => 'EUR',
            ])
            ->add('locationPrice', MoneyType::class, [
                'label' => "Prix de la location",
                'required' => false,
                'data' => 0,
                'currency' => 'EUR',
            ])
            ->add('freelancePrice', MoneyType::class, [
                'label' => "Prix participation freelance",
                'required' => false,
                'data' => 0,
                'currency' => 'EUR',
            ])
            ->add('numberLocation', NumberType::class, [
                'label' => "Nombre de location disponible",
                'required' => false,
                'data' => 0,
                'currency' => 'EUR',
            ])
            ->add('allowAnonymous', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => "Accepter les utilisateurs anonymes",
                'required' => false,
            ])
            ->add('isAtive', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Annonce visible',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
}
