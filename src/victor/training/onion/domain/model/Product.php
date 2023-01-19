<?php

namespace victor\training\onion\domain\model;

class Product
{

    private float $weightInKg;
    private float $weightInPounds;
//    private float $sizeHCm;
//    private float $sizeWCm;
//    private float $sizeLCm;
    private Size $size;
// ****PAZEA
    private ProductType $type;
    private int $providerId;


}