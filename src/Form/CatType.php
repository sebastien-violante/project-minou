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
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

class CatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
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
            ->add('details', Texttype::class)
            ->add('place', Texttype::class)
            ->add('colorstyle', Texttype::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cat::class,
        ]);
    }
}