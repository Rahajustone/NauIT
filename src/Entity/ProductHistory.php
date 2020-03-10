<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductHistoryRepository")
 */
class ProductHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productHistories")
     */
    private $productId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="productHistories")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $systemMessage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $customMessage;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?Product
    {
        return $this->productId;
    }

    public function setProductId(?Product $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format("Y-m-d");
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getSystemMessage(): ?string
    {
        return $this->systemMessage;
    }

    public function setSystemMessage(?string $systemMessage): self
    {
        $this->systemMessage = $systemMessage;

        return $this;
    }

    public function getCustomMessage(): ?string
    {
        return $this->customMessage;
    }

    public function setCustomMessage(?string $customMessage): self
    {
        $this->customMessage = $customMessage;

        return $this;
    }
}
