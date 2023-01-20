<?php

namespace victor\training\ddd\agile;

use Composer\EventDispatcher\EventSubscriberInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use victor\training\ddd\agile\events\AllItemsDoneBeforeSprintEndEvent;

//#[AsEventListener(AllItemsDoneBeforeSprintEndEvent::class, 'handle')]
//class AllItemsDoneBeforeSprintEndEventListener {
//
//    public function handle(AllItemsDoneBeforeSprintEndEvent $event): iterable
//    {
//        $event
//    }
//}

class SendEmailAdapter implements NotificationService
{
    public function __construct(
        EventDispatcherInterface $dispatcher,
             private readonly SprintRepo $sprintRepo  )
    {
        $dispatcher->addListener(AllItemsDoneBeforeSprintEndEvent::class, [$this, 'onAllItemsDoneBeforeSprintEndEvent']);
    }

    public function sendCongratsEmail(array $emails): void
    {
        echo "Sending email: Subject: Congrats! / Body: You have finished the sprint earlier. You have more time for refactor!";
   }

    public function sendNotDoneItemsDebrief(string $ownerEmail, array $notDoneItems): void
    {
        echo "The team was unable to declare 'DONE' the following items this iteration: " . notDoneItems;
    }


    private function onAllItemsDoneBeforeSprintEndEvent(AllItemsDoneBeforeSprintEndEvent $event) {
        $sprintId = $event->sprintId;
        echo "Sending CONGRATS email to team of product " . $this->sprintRepo->findOneById($sprintId)->getProduct()->getCode() .
            ": They finished the items earlier. They have time to refactor! (OMG!)";
        $emails = $this->mailingListService->retrieveEmails($this->sprintRepo->findOneById($sprintId)->getProduct()->getTeamMailingList());
        $this->emailService->sendCongratsEmail($emails);
    }

}