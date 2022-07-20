<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getproducts"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getproducts"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getproducts"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"getproducts"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getproducts"})
     */
    private $alternativeAttribute;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getproducts"})
     */
    private $screen;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getproducts"})
     */
    private $photoResolution;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getproducts"})
     */
    private $battery;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getproducts"})
     */
    private $network;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Storage::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $storage;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="products")
     */
    private $customers;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"getproducts"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"getproducts"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAlternativeAttribute(): ?string
    {
        return $this->alternativeAttribute;
    }

    public function setAlternativeAttribute(string $alternativeAttribute): self
    {
        $this->alternativeAttribute = $alternativeAttribute;

        return $this;
    }

    public function getScreen(): ?string
    {
        return $this->screen;
    }

    public function setScreen(string $screen): self
    {
        $this->screen = $screen;

        return $this;
    }

    public function getPhotoResolution(): ?string
    {
        return $this->photoResolution;
    }

    public function setPhotoResolution(string $photoResolution): self
    {
        $this->photoResolution = $photoResolution;

        return $this;
    }

    public function getBattery(): ?string
    {
        return $this->battery;
    }

    public function setBattery(string $battery): self
    {
        $this->battery = $battery;

        return $this;
    }

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(string $network): self
    {
        $this->network = $network;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getStorage(): ?Storage
    {
        return $this->storage;
    }

    public function setStorage(?Storage $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addProduct($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeProduct($this);
        }

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
}
