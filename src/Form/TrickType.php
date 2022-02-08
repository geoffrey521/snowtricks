<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('description')
            // add images field
            // He should not be connected to the database
            /*->add('images', CollectionType::class, [
                'entry_type' => FileType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
            ])*/
            // tuto field
//            ->add('images', FileType::class,[
//                    'multiple' => true,
//                    'mapped' => false,
//                    'required' => false,
//                    'constraints' => [
//                        new File([
//                            'maxSize' => '1024k',
//                            'mimeTypes' => [
//                                'application/jpeg',
//                                'application/x-jpeg'
//                            ],
//                            'mimeTypesMessage' => 'Only Jpeg format is accepted'
//                        ])
//                    ]
//            ]);
        //TEST field
            ->add('images', CollectionType::class, [
                'entry_type' => FileType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false,
                'required' => false,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => TextType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
