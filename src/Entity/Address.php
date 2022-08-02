<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"getAddress"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getAddress"})
     */
    private $path;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"getAddress"})
     */
    private $apartment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"getAddress"})
     */
    private $floor;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"getAddress"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getAddress"})
     */
    private $city;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"getAddress"})
     */
    private $resident;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getApartment(): ?int
    {
        return $this->apartment;
    }

    public function setApartment(?int $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(?int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getResident(): ?User
    {
        return $this->resident;
    }

    public function setResident(?User $resident): self
    {
        $this->resident = $resident;

        return $this;
    }

}
