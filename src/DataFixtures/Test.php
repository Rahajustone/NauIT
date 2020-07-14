<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ProductModel;
use App\Entity\ProductType;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Product;
use App\Entity\Room;
use App\Entity\Department;


class Test extends Fixture
{
    public function load(ObjectManager $manager)
    {
       

        $roleUser = new Role();
        $roleUser->setName('ROLE_USER');
        $manager->persist($roleUser);

        $manager->flush();
    }
}
