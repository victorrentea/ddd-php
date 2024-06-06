<?php

namespace victor\training\modulith\catalog\in\rest;

class GetProductResponse
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
//    private int $stock; // TODO display stock in product page UI

    private float $stars;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): GetProductResponse
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): GetProductResponse
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): GetProductResponse
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): GetProductResponse
    {
        $this->price = $price;
        return $this;
    }

    public function getStars(): float
    {
        return $this->stars;
    }
    public function setStars(float $stars): GetProductResponse
    {
        $this->stars = $stars;
        return $this;
    }


}