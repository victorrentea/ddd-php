<?php

namespace victor\training\ddd\agile;

use Exception;
use victor\training\ddd\agile\dto\SprintMetricsDto;

class CalculateSprintMetricsUseCase
{
    public function __construct(private readonly SprintRepo  $sprintRepo) {}

    #[Getmpa]
    public function getSprintMetrics(int $id): SprintMetricsDto
    {
        $sprint = $this->sprintRepo->findOneById($id);
        if ($sprint->getStatus() !== Sprint::STATUS_FINISHED) {
            throw new Exception("Illegal state");
        }
        $dto = new SprintMetricsDto();
        $dto->consumedHours = 0;
        foreach ($sprint->getItems() as $backlogItem) {
            $dto->consumedHours += $backlogItem->getHoursConsumed();
        }

        $dto->calendarDays = $sprint->getEndDate()->diff($sprint->getStartDate())->days;
        $dto->doneFP = 0;
        foreach ($sprint->getItems() as $item) {
            if ($item->getStatus() === SprintItem::STATUS_DONE) {
                $dto->doneFP += $item->getFpEstimation();
            }
        }
        $dto->fpVelocity = 1.0 * $dto->doneFP / $dto->consumedHours;

        $dto->hoursConsumedForNotDone = 0;
        foreach ($sprint->getItems() as $item) {
            if ($item->getStatus() !== SprintItem::STATUS_DONE) {
                $dto->hoursConsumedForNotDone += $item->getHoursConsumed();
            }
        }

        if ($sprint->getEndDate()->getTimestamp() > $sprint->getPlannedEnd()->getTimestamp()) {
            $dto->delayDays = $sprint->getEndDate()->diff($sprint->getPlannedEnd())->days;
        }
        return $dto;
    }

}