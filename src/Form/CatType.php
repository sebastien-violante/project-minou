<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\Breed;
use App\Repository\BreedRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('race', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name', 
                'multiple' => false,
                'expanded' => false,
                'required' => true,])
            ->add('picture', FileType::class, [
                'label' => 'Image de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '300k',
                        'maxSizeMessage' => 'Votre image ne doit pas depasser 300Ko.',
                    ])
                ],
            ])
            ->add('details')
            ->add('vaccination')
            ->add('place', null, [
                'required' => true,
            
            ])
            ->add('colorstyle', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}