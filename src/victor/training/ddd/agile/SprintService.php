<?php

namespace victor\training\ddd\agile;


use DateTime;
use Exception;
use victor\training\ddd\agile\dto\AddBacklogItemRequest;
use victor\training\ddd\agile\dto\LogHoursRequest;
use victor\training\ddd\agile\dto\SprintDto;


class SprintService
{
    public function __construct(private readonly SprintRepo         $sprintRepo,
                                private readonly ProductRepo        $productRepo,
                                private readonly BacklogItemRepo    $backlogItemRepo,
                                private readonly SprintItemRepo     $sprintItemRepo,
                                private readonly EmailService       $emailService,
                                private readonly MailingListService $mailingListService
    )
    {
    }

    public function createSprint(SprintDto $dto): int
    {
        $product = $this->productRepo->findOneById($dto->productId);
        $sprint = new Sprint($product, $dto->plannedEnd);
        return $this->sprintRepo->save($sprint)->getId();
    }

    public function getSprint(int $id): Sprint // TODO intoarce un Dto
    {
        return $this->sprintRepo->findOneById($id);
    }

    public function startSprint(int $id): void
    {
        $sprint = $this->sprintRepo->findOneById($id);
        $sprint->start();
        $this->sprintRepo->save($sprint);
    }

    public function endSprint(int $id)
    {
        $sprint = $this->sprintRepo->findOneById($id);
        $sprint->end();

        if (!($sprint->allItemsDone())) {
            $this->emailService->sendNotDoneItemsDebrief($sprint->getProduct()->getOwnerEmail(), $sprint->getItemsNotDone());
        }
        $this->sprintRepo->save($sprint);
    }

    public function addItem(int $sprintId, AddBacklogItemRequest $request): void
    {
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->addItem($request->backlogId, $request->fpEstimation);
        $this->sprintRepo->save($sprint);
    }

    public function startItem(int $sprintId, int $sprintItemId): void
    {
        // i have a dream:
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->startItem($sprintItemId);
        $this->sprintRepo->save($sprint); //#1 curat cascade: si automat doctrine salveaza toti copii (si cel nou)

        // daca vrei performanta poti sa faci startItem sa intoarca itemul de salvat -> itemRepo,save()
//      $this->backlogItemRepo->save( $sprint->findItemById($sprintItemId));
    }

    public function logHours(int $sprintId, LogHoursRequest $request): void
    {
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->logHoursOnItem($request->backlogId, $request->hours);
        $this->sprintRepo->save($sprint);
    }

    public function completeItem(int $sprintId, int $sprintItemId): void
    {
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->completeItem($sprintItemId);
        $this->sprintRepo->save($sprint);

        $allDone = true;
        foreach ($sprint->getItems() as $backlogItem) {
            if ($backlogItem->getStatus() !== SprintItem::STATUS_DONE) {
                $allDone = false;
                break;
            }
        }
        if (!$allDone) {
            echo "Sending CONGRATS email to team of product " . $sprint->getProduct()->getCode() . ": They finished the items earlier. They have time to refactor! (OMG!)";
            $emails = $this->mailingListService->retrieveEmails($sprint->getProduct()->getTeamMailingList());
            $this->emailService->sendCongratsEmail($emails);
        }
    }

}

