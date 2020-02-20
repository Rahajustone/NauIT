<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Please enter your fullname")
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message = "Please enter your username")
     * @Assert\Length(min=2, max=50)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message = "password")
     */
    private $password;


    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


   /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="createdBy")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="createdBy")
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Department", mappedBy="createdBy")
     */
    private $departments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductType", mappedBy="createdBy")
     */
    private $productTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductModel", mappedBy="createdBy")
     */
    private $productModels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="assignToUser")
     */
    private $aasignedProducts;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        // TODO
        $this->updatedAt = new \DateTime();
        $this->products = new ArrayCollection();
        $this->rooms = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->productTypes = new ArrayCollection();
        $this->productModels = new ArrayCollection();
        $this->aasignedProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        // Parse a Object to Array
        $roleLists = [];
        foreach ($roles as $key => $value) {
            $a = "".$value;
            array_push($roleLists, $a);
        }

        $this->roles = $roleLists;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCreatedBy($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCreatedBy() === $this) {
                $product->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->setCreatedBy($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
            // set the owning side to null (unless already changed)
            if ($room->getCreatedBy() === $this) {
                $room->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setCreatedBy($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->contains($department)) {
            $this->departments->removeElement($department);
            // set the owning side to null (unless already changed)
            if ($department->getCreatedBy() === $this) {
                $department->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|ProductType[]
     */
    public function getProductTypes(): Collection
    {
        return $this->productTypes;
    }

    public function addProductType(ProductType $productType): self
    {
        if (!$this->productTypes->contains($productType)) {
            $this->productTypes[] = $productType;
            $productType->setCreatedBy($this);
        }

        return $this;
    }

    public function removeProductType(ProductType $productType): self
    {
        if ($this->productTypes->contains($productType)) {
            $this->productTypes->removeElement($productType);
            // set the owning side to null (unless already changed)
            if ($productType->getCreatedBy() === $this) {
                $productType->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductModel[]
     */
    public function getProductModels(): Collection
    {
        return $this->productModels;
    }

    public function addProductModel(ProductModel $productModel): self
    {
        if (!$this->productModels->contains($productModel)) {
            $this->productModels[] = $productModel;
            $productModel->setCreatedBy($this);
        }

        return $this;
    }

    public function removeProductModel(ProductModel $productModel): self
    {
        if ($this->productModels->contains($productModel)) {
            $this->productModels->removeElement($productModel);
            // set the owning side to null (unless already changed)
            if ($productModel->getCreatedBy() === $this) {
                $productModel->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getAasignedProducts(): Collection
    {
        return $this->aasignedProducts;
    }

    public function addAasignedProduct(Product $aasignedProduct): self
    {
        if (!$this->aasignedProducts->contains($aasignedProduct)) {
            $this->aasignedProducts[] = $aasignedProduct;
            $aasignedProduct->setAssignToUser($this);
        }

        return $this;
    }

    public function removeAasignedProduct(Product $aasignedProduct): self
    {
        if ($this->aasignedProducts->contains($aasignedProduct)) {
            $this->aasignedProducts->removeElement($aasignedProduct);
            // set the owning side to null (unless already changed)
            if ($aasignedProduct->getAssignToUser() === $this) {
                $aasignedProduct->setAssignToUser(null);
            }
        }

        return $this;
    }
}
