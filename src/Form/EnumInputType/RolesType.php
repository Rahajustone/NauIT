<?php 

// TODO
// I did not use this class
namespace App\Form\EnumInputType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * 
 */
class RolesType extends AbstractType
{
    
     public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'User' => 'USER_ROLE',
                'Admin' => 'ADMIN_ROLE',
                'SuperAdmin' => 'SUPERADMIN_ROLE',
            ],
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}

 ?>