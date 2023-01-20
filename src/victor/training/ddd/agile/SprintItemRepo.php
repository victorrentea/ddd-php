<?php

namespace victor\training\ddd\agile;

interface SprintItemRepo
{
    function save(SprintItem $sprintItem): SprintItem;

    public function findOneById(int $id): SprintItem;

    public function deleteById(int $id): void;
}