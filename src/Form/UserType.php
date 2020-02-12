<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use App\Enums\RolesEnum;
use App\Form\Type\RolesInputType;
use App\Form\EnumInputType\RolesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName')
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            // ->add('roles', EntityType::class, [
            //     'class' => Role::class,
            //     'choice_label' => 'name',
            //     'attr' => ['class' => "select2", 'multiple' => "multiple" ],
            //     'multiple' => true,
            //     'required' => true
            // ])
           ->add('roles', ChoiceType::class, [
                    'placeholder' => 'Choose an option',
                    'attr'  =>  ['class' => "select2"],
                    'choices' => [
                        'ROLE_ADMIN' => "ROLE_ADMIN", 
                        'ROLE_USER' => "ROLE_USER",
                    ],
                    'multiple' => true,
                    'required' => true,
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
