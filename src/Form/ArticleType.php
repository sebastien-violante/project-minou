<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        ->add('text')
        ->add('alt')
        ->add('title')
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
