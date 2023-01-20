<?php

namespace victor\training\ddd\agile;


use DateTime;
use Exception;
use victor\training\ddd\agile\dto\AddBacklogItemRequest;
use victor\training\ddd\agile\dto\LogHoursRequest;
use victor\training\ddd\agile\dto\SprintDto;
use victor\training\ddd\agile\dto\SprintMetricsDto;


class SprintService
{
    public function __construct(private readonly SprintRepo         $sprintRepo,
                                private readonly ProductRepo        $productRepo,
                                private readonly BacklogItemRepo    $backlogItemRepo,
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
        $backlogItem = $this->backlogItemRepo->findOneById($request->backlogId);
        $sprint = $this->sprintRepo->findOneById($sprintId);
        if ($sprint->getStatus() != Sprint::STATUS_CREATED) {
            throw new Exception("Can only add items to Sprint before it starts");
        }
        $backlogItem->setSprint($sprint);
        $sprint->addItem($backlogItem);
        $backlogItem->setFpEstimation($request->fpEstimation);
    }


    public function startItem(int $sprintId, int $backlogId): void
    {
//        $this->backlogItemRepo->findOneById($backlogId)->addHours(-1);

        // i have a dream:
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->startItem($backlogId);
        $this->sprintRepo->save($sprint); //#1 curat cascade: si automat doctrine salveaza toti copii (si cel nou)

        // daca vrei performanta poti sa faci startItem sa intoarca itemul de salvat -> itemRepo,save()
//      $this->backlogItemRepo->save( $sprint->findItemById($backlogId));
    }

    public function logHours(int $sprintId, LogHoursRequest $request): void
    {
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->logHoursOnItem($request->backlogId, $request->hours);
        $this->sprintRepo->save($sprint);
    }

    public function completeItem(int $sprintId, int $backlogId): void
    {
        $sprint = $this->sprintRepo->findOneById($sprintId);
        $sprint->completeItem($backlogId);
        $this->sprintRepo->save($sprint);

        $allDone = true;
        foreach ($sprint->getItems() as $backlogItem) {
            if ($backlogItem->getStatus() !== BacklogItem::STATUS_DONE) {
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

