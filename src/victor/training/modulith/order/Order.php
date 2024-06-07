<?php

namespace victor\training\modulith\order;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use SebastianBergmann\Diff\Line;
use victor\training\modulith\common\LineItem;

#[Entity]
class Order
{
    #[Id]
    #[GeneratedValue]
    private int $id;
    private \DateTime $placedOn;
    private string $customerId;
    private string $shippingAddress;
    private float $total;
    private OrderStatus $status;
    private string $shippingTrackingNumber;

    #[OneToMany(targetEntity: LineItem::class)]
    /** @var LineItem[] */
    private array $items;

    public function paid(bool $ok): Order
    {
        if ($this->status != OrderStatus::AWAITING_PAYMENT) {
            throw new \InvalidArgumentException("Invalid status: " . $this->status->name);
        }
        $this->status = $ok ? OrderStatus::PAYMENT_APPROVED : OrderStatus::PAYMENT_FAILED;
        return $this;
    }

    public function scheduleForShipping(string $trackingNumber): Order
    {
        if ($this->status != OrderStatus::PAYMENT_APPROVED) {
            throw new \InvalidArgumentException("Invalid status: " . $this->status->name);
        }
        $this->status = OrderStatus::SHIPPING_IN_PROGRESS;
        $this->shippingTrackingNumber = $trackingNumber;
        return $this;
    }

    public function shipped(bool $ok): Order
    {
        if ($this->status != OrderStatus::SHIPPING_IN_PROGRESS) {
            throw new \InvalidArgumentException("Invalid status: " . $this->status->name);
        }
        $this->status = $ok ? OrderStatus::SHIPPING_COMPLETED : OrderStatus::SHIPPING_FAILED;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function getPlacedOn(): \DateTime
    {
        return $this->placedOn;
    }

    public function setPlacedOn(\DateTime $placedOn): Order
    {
        $this->placedOn = $placedOn;
        return $this;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): Order
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getShippingAddress(): string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(string $shippingAddress): Order
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): Order
    {
        $this->total = $total;
        return $this;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): Order
    {
        $this->status = $status;
        return $this;
    }

    public function getShippingTrackingNumber(): string
    {
        return $this->shippingTrackingNumber;
    }

    public function setShippingTrackingNumber(string $shippingTrackingNumber): Order
    {
        $this->shippingTrackingNumber = $shippingTrackingNumber;
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): Order
    {
        $this->items = $items;
        return $this;
    }

}