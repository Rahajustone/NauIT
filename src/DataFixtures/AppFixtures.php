<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Product;

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

        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
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
            $product->setAuthor($this->getReference('user'));
            $manager->persist($product);
        }

        $manager->flush();
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
            ['Rahmatullo Kholov', 'rahadmin', '123456', 'admin@na.edu', ['ROLE_ADMIN']],
            ['Ibrohim Kaduchi', 'user', 'password', 'user@na.edu', ['ROLE_USER']],
        ];
    }
}
