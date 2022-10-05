<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderDetailRepository::class)]
class OrderDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\GreaterThanOrEqual(1)]
    private int $quantity;
    
    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $products = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(nullable: false, onDelete:'cascade')]
    private ?Order $orders = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    /**
     * Check if the Order corresponds to Order given as an argument
     */
    public function checkOrder(OrderDetail $orderDetail)
    {
        return $this->getProducts()->getId() === $orderDetail->getProducts()->getId();
    }

    /**
     * Calculate total price for selected quantity of products
     */
    public function countTotal(): float
    {
        return $this->getProducts()->getPrice() * $this->getQuantity();
    }

}
