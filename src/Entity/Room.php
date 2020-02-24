<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 * @UniqueEntity("room_number")
 */
class Room
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $room_number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="rooms")
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="userRoom")
     */
    private $userRooms;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->userRooms = new ArrayCollection();
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRoomNumber(): ?string
    {
        return $this->room_number;
    }

    public function setRoomNumber(string $room_number): self
    {
        $this->room_number = $room_number;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->room_number;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserRooms(): Collection
    {
        return $this->userRooms;
    }

    public function addUserRoom(User $userRoom): self
    {
        if (!$this->userRooms->contains($userRoom)) {
            $this->userRooms[] = $userRoom;
            $userRoom->setUserRoom($this);
        }

        return $this;
    }

    public function removeUserRoom(User $userRoom): self
    {
        if ($this->userRooms->contains($userRoom)) {
            $this->userRooms->removeElement($userRoom);
            // set the owning side to null (unless already changed)
            if ($userRoom->getUserRoom() === $this) {
                $userRoom->setUserRoom(null);
            }
        }

        return $this;
    }
}
