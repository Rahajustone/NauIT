<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Room;
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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName')
            ->add('username')
            ->add('email')
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('roles', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'attr' => ['class' => "select2", 'multiple' => "multiple" ],
                'multiple' => true,
                'required' => true
            ])
            ->add('userRoom', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'name'
            ])
            ->add('profilePhoto', FileType::class, [
                'label' => 'Profile Photo',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG file',
                    ])
                ],
            ]);
            // TODO 
            // Delete this lines
           // ->add('roles', ChoiceType::class, [
           //          'placeholder' => 'Choose an option',
           //          'attr'  =>  ['class' => "select2"],
           //          'choices' => [
           //              'ROLE_ADMIN' => "ROLE_ADMIN", 
           //              'ROLE_USER' => "ROLE_USER",
           //          ],
           //          'multiple' => true,
           //          'required' => true,
           //      ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
