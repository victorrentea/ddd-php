<?php

namespace victor\training\ddd\agile;


use DateTime;
use Exception;
use victor\training\ddd\agile\dto\AddBacklogItemRequest;
use victor\training\ddd\agile\dto\LogHoursRequest;
use victor\training\ddd\agile\dto\SprintDto;


class SprintApplicationService
{
    public function __construct(private readonly SprintRepo          $sprintRepo,
                                private readonly ProductRepo         $productRepo,
                                private readonly BacklogItemRepo     $backlogItemRepo,
                                private readonly SprintItemRepo      $sprintItemRepo,
                                private readonly NotificationService $notificationService,
                                private readonly MailingListService  $mailingListService
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
            $this->notificationService->sendNotDoneItemsDebrief($sprint->getProduct()->getOwnerEmail(), $sprint->getItemsNotDone());
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

        // ###1 Event aruncat de catre save() printr-un hook de ORM care te anunta cand a rulat INSERTul cu succes in DB
        //   ( Mai bine decat Event aruncat din completeItem NU pt ca poata crapa save() dupa )
        //   AM NOROC ca vreau fire-and-forget => merge eventuri
        //   SCOP: pt ca e un flux unrelated (alta Marie..., SRP)
        //   implem: AggRoot aduna un array de 'eventsToPublish' iar @PostFlush hook-ul le publica pe EventPublisherInterface

        // ###2 Las-o asa (adica lasa orchestrarea aici din ApplicationService)
        //   Risk? era o biz-regula: la terminarea sprintului tre trimis un mail
        //   In alta parte in app mea MARE(😏) fac sprint->completeItem() si acolo dar uit de if

        // ###3
//        $sprint->completeItem($sprintItemId);

        // DE CE OOP:
        // TOCMAI AM GASIT pe obiectul din fata mea (din Domain Model) o functie convenient => Reuse si nu copy paste.
        // fata de a cauta intr-un <Sprint> Util/Helper
    }

}

