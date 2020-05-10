<?php

namespace App\Form;

use App\Entity\Participate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ParticipateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isAuth = $options['isAuth'];

        if($isAuth == false)
        {
            $builder
                ->add('author', TextType::class, [
                    'label' => "Nom d'utilisateur",
                    'required' => true,
                ])
            ;
        }
        $builder
            ->add('note', TextareaType::class, [
                'label' => 'Note ou précision',
                'required' => false,
            ])
            ->add('visitor', NumberType::class, [
                'label' => "Nombre d'invité",
                'required' => false,
                'data' => 0,
            ])
            ->add('equipment', NumberType::class, [
                'label' => "Nombre d'équipement reservé",
                'required' => false,
                'data' => 0,
            ])
            ->add('locomotion', ChoiceType::class, [
                'label' => "Moyen de locomotion",
                'required' => true,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participate::class,
            'isAuth' => null,
        ]);
    }
}
