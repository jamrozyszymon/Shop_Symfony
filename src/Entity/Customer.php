<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[Assert\Email(
        message: 'Wprowadzony email: {{ value }}, nie jest poprawny.',
    )]
    #[ORM\Column(length: 80, unique:true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\NotBlank(
        message: 'Pole nie może być puste',
    )]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Assert\NotBlank(
        message: 'Pole nie może być puste',
    )]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[Assert\NotBlank(
        message: 'Pole nie może być puste',
    )]
    #[ORM\Column(length: 255)]
    private ?string $Address = null;

    #[Assert\NotBlank(
        message: 'Pole nie może być puste',
    )]
    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\OneToMany(mappedBy: 'customers', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->created_at = new \DateTimeImmutable("now");

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomers($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomers() === $this) {
                $order->setCustomers(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }
}
