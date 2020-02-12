<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Product;
use App\Entity\Room;
use App\Entity\Department;

class AppFixtures extends Fixture
{
	private $passwordEncoder;

	public function  __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadProduct($manager);
        $this->loadRooms($manager);
        $this->loadDepartment($manager);
        $this->loadRole($manager);

        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, "123456"));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    public function loadRole(ObjectManager $manager)
    {
        $role = new Role();
        $role->setName('ROLE_ADMIN');
        $manager->persist($role);

        $roleUser = new Role();
        $roleUser->setName('ROLE_USER');
        $manager->persist($roleUser);
    }


    public function loadProduct(ObjectManager $manager)
    {

        for ($i = 0; $i < 200; $i++) {
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setIpAddress($this->generateIpAddress());
            $product->setMacAdrress($this->generateMacAddress());
            $product->setOs($this->generateOs());
            $product->setPrice(mt_rand(10, 100));
            $product->setUpdatedAt();
            $product->setCreatedBy($this->getReference('user'));
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function loadRooms(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {
            $product = new Room();
            $product->setName('It'.$i);
            $product->setCreatedBy($this->getReference('user'));
            $product->setRoomNumber("Room".$i);
            $manager->persist($product);
        }
    }

    public function loadDepartment(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; $i++) {
            $department = new Department();
            $department->setName('Department -'.$i);
            $department->setCreatedBy($this->getReference('user'));
            $manager->persist($department);
        }
    }

    private function generateIpAddress()
    {
        return  "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
    }

    private function generateMacAddress()
    {
        return implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));
    }

    private function generateOs()
    {
        $os = ["Linux", 'Windows', "Macos"];

        return $os[mt_rand(0,2)];
    }

    private function strGenerator($length)
    { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $length; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
  
        return $randomString; 
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['Rahmatullo Kholov', 'rahadmin', '123456', 'admin@na.edu', ['ROLE_ADMIN', 'ROLE_USER']],
            ['Ibrohim Kaduchi', 'user', 'password', 'user@na.edu', ['ROLE_USER']],
        ];
    }
}
