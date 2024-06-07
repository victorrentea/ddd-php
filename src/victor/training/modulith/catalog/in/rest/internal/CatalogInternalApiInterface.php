<?php

namespace victor\training\modulith\catalog\in\rest\internal;

interface CatalogInternalApiInterface
{
    public function getManyPrices(array $ids): array;
}