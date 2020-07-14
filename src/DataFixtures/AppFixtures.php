<?php

namespace App\DataFixtures;

use App\Entity\ProductModel;
use App\Entity\ProductType;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Product;
use App\Entity\Room;
use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	private $passwordEncoder;

	public function  __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadRole($manager);
        $this->loadUser($manager);
        $this->loadDepartment($manager);
        $this->loadRoom($manager);
        $this->loadProductModel($manager);
        $this->loadProductType($manager);
        $this->loadProduct($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadRole(ObjectManager $manager)
    {
        $role = new Role();
        $role->setName('ROLE_ADMIN');
        $manager->persist($role);

        $roleUser = new Role();
        $roleUser->setName('ROLE_USER');
        $manager->persist($roleUser);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadUser(ObjectManager $manager)
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

    /**
     * @param ObjectManager $manager
     */
    private  function loadProductModel(ObjectManager $manager){
        for ( $i=0; $i< 1; $i++){
            $productModel = new ProductModel();
            $productModel->setName($this->strGenerator(7));
            $productModel->setCreatedBy($this->getReference('user'));
            $manager->persist($productModel);

            $this->setReference("loadProductModel", $productModel);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadProductType(ObjectManager $manager){
        for ($i =0; $i< 1; $i++){
            $productType = new ProductType();
            $productType->setName($this->strGenerator(7));
            $productType->setCreatedBy($this->getReference('user'));

            $manager->persist($productType);

            $this->setReference("loadProductType", $productType);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadProduct(ObjectManager $manager)
    {

        for ($i = 0; $i < 1; $i++) {
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setIpAddress($this->generateIpAddress());
            $product->setMacAddress($this->generateMacAddress());
            $product->setOs($this->generateOs());
            $product->setPrice(mt_rand(10, 100));
            $product->setUpdatedAt();
            $product->setCreatedBy($this->getReference('user'));
            $product->setModelType($this->getReference('loadProductType'));
            $product->setProductModel($this->getReference('loadProductModel'));
            $product->setStatus("inuse");
            $product->setSerialNumber($this->generateSerialNumber());
            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadRoom(ObjectManager $manager)
    {
        for ($i = 0; $i < 1; $i++) {
            $product = new Room();
            $product->setName('It'.$i);
            $product->setCreatedBy($this->getReference('user'));
            $product->setRoomNumber("Room".$i);
            $manager->persist($product);
        }
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadDepartment(ObjectManager $manager)
    {
        for ($i = 0; $i < 1; $i++) {
            $department = new Department();
            $department->setName('Department -'.$i);
            $department->setCreatedBy($this->getReference('user'));
            $manager->persist($department);
        }
    }

    /**
     * @return string
     */
    private function generateIpAddress()
    {
        return  "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
    }

    /**
     * @return string
     */
    private function generateMacAddress()
    {
        return implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));
    }

    /**
     * @return mixed
     */
    private function generateOs()
    {
        $os = ["Linux", 'Windows', "Macos"];

        return $os[mt_rand(0,2)];
    }

    /**
     * @return string
     */
    private function generateSerialNumber():string
    {
        return "NU".$this->strGenerator(8);
    }

    /**
     * @param $length
     * @return string
     */
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

    /**
     * @return array
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['Rahmatullo Kholov', 'rahadmin', '123456', 'admin@na.edu', ['ROLE_ADMIN']],
            ['Ibrohim Kaduchi', 'user', 'password', 'user@na.edu', ['ROLE_USER']],
        ];
    }
}
