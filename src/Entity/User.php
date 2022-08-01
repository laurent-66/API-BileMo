<?php

namespace App\Entity;

use App\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * 
 * @Hateoas\Relation(
 *      "self",
 *      href = "expr('/api/customers/' ~ object.getCustomer().getId() ~ '/users/' ~ object.getId())",
 *      exclusion = @Hateoas\Exclusion(groups="getUsers")
 * )
 * 
 * @Hateoas\Relation(
 *      "delete",
 *      href = "expr('/api/customers/' ~ object.getCustomer().getId() ~ '/users/' ~ object.getId())",
 *      exclusion = @Hateoas\Exclusion(groups="getUsers")
 * )
 * 
 * 
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getUsers"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getUsers", "postUsers"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getUsers", "postUsers"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"getUsers", "postUsers"})
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"getUsers", "getCustomers"})
     */
    private $customer;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="resident", cascade={"ALL"})
     * @Groups({"getUsers", "getAddress"}) 
     */
    private $addresses;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"getUsers", "getCustomers", "postUsers"})
     * @Since("2.0")
     */
    private $subscriptionAnniversaryDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"getUsers", "getCustomers", "postUsers"})
     * @Since("2.0")
     */
    private $comment;


    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setResident($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getResident() === $this) {
                $address->setResident(null);
            }
        }

        return $this;
    }

    public function getSubscriptionAnniversaryDate(): ?\DateTimeInterface
    {
        return $this->subscriptionAnniversaryDate;
    }

    public function setSubscriptionAnniversaryDate(\DateTimeInterface $subscriptionAnniversaryDate): self
    {
        $this->subscriptionAnniversaryDate = $subscriptionAnniversaryDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
