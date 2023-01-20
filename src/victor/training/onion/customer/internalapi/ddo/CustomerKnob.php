<?php

namespace victor\training\onion\customer\internalapi\ddo;

readonly class CustomerKnob
{
    public function __construct(
            public int $id,
            public string $name,
            public string $address
    )
    {
    }

}