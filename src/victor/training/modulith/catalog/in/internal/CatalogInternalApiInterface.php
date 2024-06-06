<?php

namespace victor\training\modulith\catalog\in\internal;

interface CatalogInternalApiInterface
{
    public function getManyPrices(array $ids): array;
}