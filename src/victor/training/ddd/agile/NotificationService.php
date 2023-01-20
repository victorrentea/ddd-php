<?php

namespace victor\training\ddd\agile;

interface NotificationService
{
    public function sendCongratsEmail(array $emails): void;

    public function sendNotDoneItemsDebrief(string $ownerEmail, array $notDoneItems): void;

    public function sendCongratsEmailMaiIncapsulat(int $getId);
}