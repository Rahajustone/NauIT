<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductModel;
use App\Entity\ProductType as ProductModelType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('serialNumber')
            ->add('ipAddress', TextType::class, [ 
                "attr" => [ "class" => "ipnumber"]
                ])
            ->add('macAdrress', TextType::class, [
                "attr" => [ "class" => "macnumber"]
            ])
            ->add('os', ChoiceType::class, [
                'choices' => [
                    "Windows" => "Windows",
                    "Linux" => "Linux",
                    "iOS" => "iOS",
                    "Android" => "Android",
                    "Other" => "Other"
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'In Storage' => 'instorage',
                    'In Use' => 'inuse',
                    'Broken' => 'broken',
                    'Sold' => 'sold',
                    'In Repair' => 'inrepair'
                ]
            ])
            ->add('modelType', EntityType::class, [
                'class' => ProductModelType::class,
                'choice_label' => 'name'
            ])
            ->add('productModel', EntityType::class, [
                'class' => ProductModel::class,
                'choice_label' => 'name'
            ])
            ->add('price')
            ->add('quantity', IntegerType::class, [
                'data' => '1'
            ])
            ->add('comments', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
