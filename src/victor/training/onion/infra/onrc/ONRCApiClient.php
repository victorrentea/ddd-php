<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorRentea
 * Date: 9/18/2017
 * Time: 10:35 PM
 */

namespace victor\training\onion\infra\onrc;

class ONRCApiClient
{
    public function search(?string $namePart, ?string $onrcId, ?string $cif) {
        // Imagine a remote API Call happens here
        return DummyData::getData();
    }

}