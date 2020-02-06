<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
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
}
