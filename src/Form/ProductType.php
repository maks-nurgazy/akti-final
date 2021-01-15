<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Truck;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>[
                    'placeholder'=>'name',
                    'class'=>'form name'
                ]
            ])
            ->add('price',IntegerType::class,[
                'attr'=>[
                    'placeholder'=>'price',
                    'class'=>'form price'
                ]
            ])
            ->add('data',DateTimeType::class,[
                'attr'=>[
                    'placeholder'=>'date',
                    'class'=>'form date'

                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'description',
                    'class'=>'form description'

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
