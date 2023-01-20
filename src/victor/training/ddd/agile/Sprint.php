<?php

namespace victor\training\ddd\agile;


use Cassandra\Date;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Exception;


class Sprint
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_STARTED = 'STARTED';
    const STATUS_FINISHED = 'FINISHED';

    private ?int $id;
    private int $iteration;
    #[ManyToOne]
    private Product $product;
//    #[Column]
    private ?DateTime $startDate;
    private DateTime $plannedEnd;
    private ?DateTime $endDate;

    private string $status = self::STATUS_CREATED;

    #[OneToMany(cascade: ['all'] )]
   /** @var BacklogItem[] */
   private array $items = [];

    public function __construct(Product $product, DateTime $plannedEnd)
    {
        $this->product = $product;
        $this->iteration = $product->incrementAndGetIteration();
        $this->plannedEnd = $plannedEnd;
    }


    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): Sprint
    {
        $this->id = $id;
        return $this;
    }
    public function getIteration(): int
    {
        return $this->iteration;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }
    public function setStartDate(DateTime $startDate): Sprint
    {
        $this->startDate = $startDate;
        return $this;
    }
    public function getPlannedEnd(): DateTime
    {
        return $this->plannedEnd;
    }
    public function setPlannedEnd(DateTime $plannedEnd): Sprint
    {
        $this->plannedEnd = $plannedEnd;
        return $this;
    }
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }
    public function setEndDate(DateTime $endDate): Sprint
    {
        $this->endDate = $endDate;
        return $this;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $status): Sprint
    {
        $this->status = $status;
        return $this;
    }
    public function getItems(): array
    {
        return $this->items;
    }
    public function setItems(array $items): Sprint
    {
        $this->items = $items;
        return $this;
    }

    public function addItem(BacklogItem $backlogItem): void
    {
        $this->items [] = $backlogItem;
    }

    public function start(): void
    {
        if ($this->status !== Sprint::STATUS_CREATED) {
            throw new Exception("Illegal State");
        }
        $this->startDate = new DateTime();
        $this->status = Sprint::STATUS_STARTED;
    }

    public function end(): void
    {
        if ($this->status !== Sprint::STATUS_STARTED) {
            throw new Exception("Illegal State");
        }
        $this->endDate = new DateTime();
        $this->status = Sprint::STATUS_FINISHED;
    }

    function allItemsDone(): bool
    {
        return empty($this->getItemsNotDone());
    }

    /** @return BacklogItem[] */
     function getItemsNotDone(): array {
        $notDoneItems = [];
        foreach ($this->items as $backlogItem) {
            if ($backlogItem->getStatus() !== BacklogItem::STATUS_DONE) {
                $notDoneItems [] = $backlogItem;
            }
        }
        return $notDoneItems;
    }

    public function startItem(int $backlogId): void
    {
        $backlogItem = $this->findItemById($backlogId);
        $this->assertStarted();
        $backlogItem->start();
    }

    public function completeItem(int $backlogId): void
    {
        $backlogItem = $this->findItemById($backlogId);
        $this->assertStarted();
        $backlogItem->complete();
    }
    public function logHoursOnItem(int $backlogId, int $hours): void
    {
        $backlogItem = $this->findItemById($backlogId);
        $this->assertStarted();
        $backlogItem->addHours($hours);
    }

    private function findItemById(int $backlogId): BacklogItem
    {
        foreach ($this->items as $item) {
            if ($item->getId() === $backlogId) return $item;
        }
        throw new Exception("Nu-i $backlogId");
    }

    public function assertStarted(): void
    {
        if ($this->status != Sprint::STATUS_STARTED) {
            throw new Exception("Sprint not started");
        }
    }
}