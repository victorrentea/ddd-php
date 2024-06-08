<?php

namespace victor\training\modulith\catalog\app;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;


#[Entity]
class Product
{
    #[Id]
    #[GeneratedValue]
    private int $id;

    private $name;

    private $description;

    private $price;

    private $stars;

    #[
        OneToMany(targetEntity: ProductReview::class, mappedBy: "product")
    ]
    private $reviews;

    public bool $inStock;


    public function __construct()
    {
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getStars()
    {
        return $this->stars;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
        return $this;
    }

    public function getReviews(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->reviews;
    }

    public function setReviews(\Doctrine\Common\Collections\ArrayCollection $reviews): Product
    {
        $this->reviews = $reviews;
        return $this;
    }

    // getters and setters

}