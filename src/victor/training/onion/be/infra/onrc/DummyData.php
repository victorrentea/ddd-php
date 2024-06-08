<?php
/**
 * Created by IntelliJ IDEA.
 * User: VictorRentea
 * Date: 9/18/2017
 * Time: 10:30 PM
 */

namespace victor\training\onion\be\infra\onrc;


class DummyData
{
    public static function getData(): array {
        $ldapUser1 = [
            "shortName" => "John",
            "extendedFullName" => "DOE",
            "onrcId" => "jdoe",
            "registrationDate" => new \DateTime(),
            "mainEml" => "0123456789",
            "emailAddresses" => [
                ["type" => "WORK", "email" => "OFFICE@office.com"]
                //type can be case OFFICE;//    case LEGAL;//    case SALES;
            ]
        ];
        $ldapUser2 = [
            "shortName" => "Jane",
            "extendedFullName" => "DOE",
            "onrcId" => "janedoe",
            "registrationDate" => new \DateTime()
        ];
        return [$ldapUser1, $ldapUser2];
    }
}