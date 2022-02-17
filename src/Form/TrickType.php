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
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints as Assert;


class TrickType extends AbstractType
{
    public function __construct(private VideoToLinkTransform $transformer)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('description')
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
            //    'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => 'You need to add 1 video minimum'
                    ]),
                    new Assert\All([
                        new Url([
                            'message' => 'Please insert a valide url, youtube or dailymotion'
                        ]),
                        new Assert\Regex([
                            'pattern' => '(youtube\.com|dailymotion\.com)',
                            'message' => 'please insert a youtube or dailymotion url'
                        ])
                    ])
                ]

            ])
        ;

        $builder->get('videos')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
