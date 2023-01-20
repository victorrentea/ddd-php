<?php

namespace victor\training\ddd\agile;


use DateTime;
use Exception;
use victor\training\ddd\agile\dto\AddBacklogItemRequest;
use victor\training\ddd\agile\dto\LogHoursRequest;
use victor\training\ddd\agile\dto\SprintDto;
use victor\training\ddd\agile\dto\SprintMetrics;


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
            $this->emailService->sendNotDoneItemsDebrief($sprint->getProduct()->getOwnerEmail(), $notDoneItems);
        }
        $this->sprintRepo->save($sprint);
    }

    public function getSprintMetrics(int $id): SprintMetrics
    {
        $sprint = $this->sprintRepo->findOneById($id);
        if ($sprint->getStatus() !== Sprint::STATUS_FINISHED) {
            throw new Exception("Illegal state");
        }
        $dto = new SprintMetrics();
        $dto->consumedHours = 0;
        foreach ($sprint->getItems() as $backlogItem) {
            $dto->consumedHours += $backlogItem->getHoursConsumed();
        }

        $dto->calendarDays = $sprint->getEndDate()->diff($sprint->getStartDate())->days;
        $dto->doneFP = 0;
        foreach ($sprint->getItems() as $item) {
            if ($item->getStatus() === BacklogItem::STATUS_DONE) {
                $dto->doneFP += $item->getFpEstimation();
            }
        }
        $dto->fpVelocity = 1.0 * $dto->doneFP / $dto->consumedHours;

        $dto->hoursConsumedForNotDone = 0;
        foreach ($sprint->getItems() as $item) {
            if ($item->getStatus() !== BacklogItem::STATUS_DONE) {
                $dto->hoursConsumedForNotDone += $item->getHoursConsumed();
            }
        }

        if ($sprint->getEndDate()->getTimestamp() > $sprint->getPlannedEnd()->getTimestamp()) {
            $dto->delayDays = $sprint->getEndDate()->diff($sprint->getPlannedEnd())->days;
        }
        return $dto;
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


    public function startItem(int $id, int $backlogId): void
    {
        $backlogItem = $this->backlogItemRepo->findOneById($backlogId);
        $this->checkSprintMatchesAndStarted($id, $backlogItem);
        if ($backlogItem->getStatus() != BacklogItem::STATUS_CREATED) {
            throw new Exception("Item already started");
        }
        $backlogItem->setStatus(BacklogItem::STATUS_STARTED);
    }

    private function checkSprintMatchesAndStarted(int $id, BacklogItem $backlogItem): void
    {
        if ($backlogItem->getSprint()->getId() !== $id) {
            throw new Exception("item not in sprint");
        }

        $sprint = $this->sprintRepo->findOneById($id);
        if ($sprint->getStatus() != Sprint::STATUS_STARTED) {
            throw new Exception("Sprint not started");
        }
    }

    public function completeItem(int $id, int $backlogId): void
    {
        $backlogItem = $this->backlogItemRepo->findOneById($backlogId);
        $this->checkSprintMatchesAndStarted($id, $backlogItem);
        if ($backlogItem->getStatus() != BacklogItem::STATUS_STARTED) {
            throw new Exception("Cannot complete an Item before starting it");
        }
        $backlogItem->setStatus(BacklogItem::STATUS_DONE);
        $sprint = $this->sprintRepo->findOneById($id);

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

    public function logHours(int $id, LogHoursRequest $request): void
    {
        $backlogItem = $this->backlogItemRepo->findOneById($request->backlogId);
        $this->checkSprintMatchesAndStarted($id, $backlogItem);
        if ($backlogItem->getStatus() !== BacklogItem::STATUS_STARTED) {
            throw new Exception("Item not started");
        }
        $backlogItem->addHours($request->hours);
    }

}

