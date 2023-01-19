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
    /* @return ONRCLegalEntityDto[] */
    public function search(?string $namePart, ?string $onrcId, ?string $cif) {
        // Imagine a remoote API Call happens here returning an array of responses
        return DummyData::getData();
    }

}