<?php

namespace App\Form;

use App\Entity\Trick;
use App\Form\DataTransformer\VideoToLinkTransform;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Url;

class TrickType extends AbstractType
{
    public function __construct(private VideoToLinkTransform $videoTransform)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('description')
            ->add('photos', CollectionType::class, [
                'entry_type' => FileType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\All([
                        new Image(),
                    ]),
                ],
            ])
            ->add('links', CollectionType::class, [
                'entry_type' => TextType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Assert\All([
                        new Url(),
                        new Assert\Regex([
                            'pattern' => '(youtube\.com|dailymotion\.com)',
                            'message' => 'Please insert a youtube or dailymotion url',
                        ]),
                    ]),
                ],
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
