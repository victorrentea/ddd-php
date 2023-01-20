<?php

namespace victor\training\ddd\agile;

class SendEmailAdapter implements NotificationService
{

    public function sendCongratsEmail(array $emails): void
    {
        echo "Sending email: Subject: Congrats! / Body: You have finished the sprint earlier. You have more time for refactor!";
   }

    public function sendNotDoneItemsDebrief(string $ownerEmail, array $notDoneItems): void
    {
        echo "The team was unable to declare 'DONE' the following items this iteration: " . notDoneItems;
    }

    public function sendCongratsEmailMaiIncapsulat(int $getId)
    {
        echo "Sending CONGRATS email to team of product " . $sprint->getProduct()->getCode() .
            ": They finished the items earlier. They have time to refactor! (OMG!)";
        $emails = $this->mailingListService->retrieveEmails($sprint->getProduct()->getTeamMailingList());
        $this->emailService->sendCongratsEmail($emails);
    }
}