<?php

namespace victor\training\modulith\catalog\app;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class ProductReview
{
    #[Id]
    #[GeneratedValue]
    private int $id;
    #[ManyToOne(targetEntity: Product::class, inversedBy: "reviews")]
    private Product $product;
    private string $title;
    private string $content;
    private int $stars;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): ProductReview
    {
        $this->id = $id;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): ProductReview
    {
        $this->product = $product;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): ProductReview
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): ProductReview
    {
        $this->content = $content;
        return $this;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): ProductReview
    {
        $this->stars = $stars;
        return $this;
    }

}