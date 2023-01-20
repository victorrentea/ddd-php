<?php

namespace victor\training\ddd\agile;




use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Exception;
use victor\training\ddd\agile\ddd\DDDEntity;

#[DDDEntity]
#[Entity]
class SprintItem
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_STARTED = 'STARTED';
    const STATUS_DONE = 'DONE';

    #[Id]
    private int $id;
    private int $sprintId;

    // are FK -> BACKLOG_ITEM.ID
    private int $backlogItemId;

    private int $fpEstimation;
    private string $status = self::STATUS_CREATED;
    private int $hoursConsumed = 0;

    public function __construct(int $sprintId, int $backlogItemId, int $fpEstimation)
    {
        $this->sprintId = $sprintId;
        $this->backlogItemId = $backlogItemId;
        $this->fpEstimation = $fpEstimation;
    }


    /** @deprecated nu o folosi in codul de service, ci e doar aici pentru tata Sprint (AggRoot) */
    public function addHours(int $hours): void
    {
        if ($this->status !== SprintItem::STATUS_STARTED) {
            throw new Exception("Item not started");
        }
        $this->hoursConsumed += $hours;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFpEstimation(): int
    {
        return $this->fpEstimation;
    }

    public function getHoursConsumed(): int
    {
        return $this->hoursConsumed;
    }
    /** @deprecated nu o folosi in codul de service, ci e doar aici pentru tata Sprint (AggRoot) */
    public function start(): void
    {
        if ($this->status != SprintItem::STATUS_CREATED) {
            throw new Exception("Item already started");
        }
        $this->status = SprintItem::STATUS_STARTED;
    }

    /** @deprecated nu o folosi in codul de service, ci e doar aici pentru tata Sprint (AggRoot) */
    public function complete(): void
    {
        if ($this->status != SprintItem::STATUS_STARTED) {
            throw new Exception("Cannot complete an Item before starting it");
        }
        $this->status=  SprintItem::STATUS_DONE;
    }
}
