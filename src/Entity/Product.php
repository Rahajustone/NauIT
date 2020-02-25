<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $macAdrress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $os;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductType", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modelType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductModel", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productModel;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $serialNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="aasignedProducts")
     */
    private $assignToUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductHistory", mappedBy="productId")
     */
    private $productHistories;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->productHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getMacAdrress(): ?string
    {
        return $this->macAdrress;
    }

    public function setMacAdrress(string $macAdrress): self
    {
        $this->macAdrress = $macAdrress;

        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(string $os): self
    {
        $this->os = $os;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments(string $comments)
    {
        $this->comments = $comments;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getModelType(): ?ProductType
    {
        return $this->modelType;
    }

    public function setModelType(?ProductType $modelType): self
    {
        $this->modelType = $modelType;

        return $this;
    }

    public function getProductModel(): ?ProductModel
    {
        return $this->productModel;
    }

    public function setProductModel(?ProductModel $productModel): self
    {
        $this->productModel = $productModel;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getAssignToUser(): ?User
    {
        return $this->assignToUser;
    }

    public function setAssignToUser(?User $assignToUser): self
    {
        $this->assignToUser = $assignToUser;

        return $this;
    }

    /**
     * @return Collection|ProductHistory[]
     */
    public function getProductHistories(): Collection
    {
        return $this->productHistories;
    }

    public function addProductHistory(ProductHistory $productHistory): self
    {
        if (!$this->productHistories->contains($productHistory)) {
            $this->productHistories[] = $productHistory;
            $productHistory->setProductId($this);
        }

        return $this;
    }

    public function removeProductHistory(ProductHistory $productHistory): self
    {
        if ($this->productHistories->contains($productHistory)) {
            $this->productHistories->removeElement($productHistory);
            // set the owning side to null (unless already changed)
            if ($productHistory->getProductId() === $this) {
                $productHistory->setProductId(null);
            }
        }

        return $this;
    }
}
