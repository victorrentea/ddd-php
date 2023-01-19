<?php

namespace victor\training\onion\domain\model;

//ValueObject
// - mic
// - imutabil
// - nu are PK
// - daca vreodata tre sa-i faci equals
class Size
{
    private int $hCm;
    private int $wCm;
    private int $lCm;

    public function __construct(int $hCm, int $wCm, int $lCm)
    {
        $this->hCm = $hCm;
        $this->wCm = $wCm;
        $this->lCm = $lCm;
    }

//    function equals(Size $other):bool
//    {
//         // incluzi in equals toate campurile.
//    }

    public function getHCm(): int
    {
        return $this->hCm;
    }

    public function getWCm(): int
    {
        return $this->wCm;
    }

    public function getLCm(): int
    {
        return $this->lCm;
    }


}