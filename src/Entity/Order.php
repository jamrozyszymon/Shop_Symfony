<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
class Order
{
    const STATUS ='cart';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique:true, nullable: true)]
    private ?string $number = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Delivery $deliveries = null;

    #[ORM\Column]
    private ?\DateTime $created_at;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $status = self::STATUS;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: OrderDetail::class, cascade: ["persist", "remove"], orphanRemoval:true)]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getdeliveries(): ?Delivery
    {
        return $this->deliveries;
    }

    public function setdeliveries(?Delivery $deliveries): self
    {
        $this->deliveries = $deliveries;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    /**
     * With possibilities to override data in DoctrineFixtrure
     */
    #[ORM\PrePersist]
    public function setCreatedAt()
    {
        if(isset($this->created_at_fixture)){
            $this->created_at = $this->created_at_fixture;
        } else {
        $this->created_at = new \DateTime("now");
        return $this;
        }
    }

    public function setCreatedAtFixture($created_at)
    {
        $this->created_at_fixture = $created_at;
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $update_at): self
    {
        $this->updated_at = $update_at;

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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, OrderDetail>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        foreach ($this->getOrderDetails() as $existingOrderDetail) {
            if($existingOrderDetail->checkOrder($orderDetail)) {
                $existingOrderDetail->setQuantity($existingOrderDetail->getQuantity()+ $orderDetail->getQuantity());
                return $this;
            }
        }
        // if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setOrders($this);
        // }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getOrders() === $this) {
                $orderDetail->setOrders(null);
            }
        }

        return $this;
    }

    /**
     * Remove all products from cart
     */
    public function removeAllOrderDetail(): self
    {
        foreach($this->getOrderDetails() as $allOrderDetails) {
            $this->removeOrderDetail($allOrderDetails);
        }
        return $this;
    }

    /**
     * Calculate total price for cart
     */
    public function countTotal(): float
    {
        $total=0;

        foreach($this->getOrderDetails() as $orderDetail) {
            $total += $orderDetail->countTotal();
        }
        return $total;
    }

    public function __toString()
    {
        return $this->id;
    }
}
