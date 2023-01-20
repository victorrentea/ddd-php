<?php

namespace victor\training\ddd\agile;




use Doctrine\ORM\Mapping\Entity;
use Exception;
use victor\training\ddd\agile\ddd\DDDEntity;

#[DDDEntity] // draga colegu', nu modifica direct starea clasei asteia ci dute-n AggregRoot.
#[Entity]
class BacklogItem
{

    private int $id;
    // nu e necesar pt ca nici un UC nu cere copilului sa se duca in parinte
//    #[OneToMany]
    private Product $product;
//    private int $productId;

    private string $title;
    private string $description;

    private int $version; // for optimistic locking

    public function __construct(Product $product, string $title, string $description)
    {
        $this->product = $product;
        $this->title = $title;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BacklogItem
    {
        $this->id = $id;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): BacklogItem
    {
        $this->product = $product;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BacklogItem
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): BacklogItem
    {
        $this->description = $description;
        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): BacklogItem
    {
        $this->version = $version;
        return $this;
    }
}
