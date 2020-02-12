<?php

// TODO
// I did not use this class
namespace App\Form\DataTransformer;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Component\Form\DataTransformerInterface;

class RoleArrayToStringTransformer implements DataTransformerInterface
{
    private $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($roles): string
    {
        return implode(',', $roles);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string): array
    {
        if ('' === $string || null === $string) {
            return [];
        }

        $names = array_filter(array_unique(array_map('trim', explode(',', $string))));

        // Get the current Roles and find the new ones that should be created.
        $roles = $this->roles->findBy([
            'name' => $names,
        ]);
        $newNames = array_diff($names, $roles);
        foreach ($newNames as $name) {
            $role = new Role();
            $role->setName($name);
            $roles[] = $role;

        }

        // Return an array of Roles to transform them back into a Doctrine Collection.
        // See Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer::reverseTransform()
        return $roles;
    }
}
