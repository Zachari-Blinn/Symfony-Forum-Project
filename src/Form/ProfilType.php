<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\User;
use App\Entity\Region;
use App\Entity\Department;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'application/png',
                            'application/jpeg',
                            'application/jpg',
                            'application/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudonyme',
                'required' => true,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Non-spécifié' => null,
                    'Homme' => 1,
                    'Femme' => 0,
                ],
                'required' => true,
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'required' => false,
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'placeholder' => 'selectionnez votre region',
                'mapped' => false,
                'required' => false,
            ])
        ;
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addDepartmentField($form->getParent(), $form->getData());
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function(FormEvent $event)
            {
                $data = $event->getData();
                /* @var $ville Ville */
                $city = $data->getCity();
                $form = $event->getForm();
                if($city)
                {
                    $department = $city->getDepartment();
                    $region = $department->getRegion();
                    $this->addDepartmentField($form, $region);
                    $this->addCityField($form, $department);
                    $form->get('region')->setData($region);
                    $form->get('department')->setData($department);
                }
                else
                {
                    $this->addDepartmentField($form, null);
                    $this->addCityField($form, null);
                }
            }
        );
    }

    private function addDepartmentField(FormInterface $form, ?Region $region)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder('department', EntityType::class, null, [
            'class' => Department::class,
            'placeholder' => $region ? 'selectionnez votre departement' : 'selectionnez votre region',
            'mapped' => false,
            'required' => false,
            'auto_initialize' => false,
            'choices' => $region ? $region->getDepartments() : []
        ]);
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event)
            {
                $form = $event->getForm();
                $this->addCityField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    private function addCityField(FormInterface $form, ?Department $department)
    {
        $form->add('city', EntityType::class, [
            'class' => City::class,
            'placeholder' => $department ? 'selectionnez votre ville' : 'selectionnez votre departement',
            'choices'     => $department ? $department->getCities() : [],
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
