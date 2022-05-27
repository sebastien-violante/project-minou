<?php

namespace App\Form;

use App\Entity\Cat;
use App\Entity\Breed;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('race', EntityType::class, [
                'class' => Breed::class,
                'multiple' => true,
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
            ->add('place')
            ->add('colorstyle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}