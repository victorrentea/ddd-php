<?php

namespace victor\training\ddd\agile\dto;

class SprintMetrics
{
    public int $consumedHours;
    public int $doneFP;
    public float $fpVelocity;
    public int $hoursConsumedForNotDone;
    public int $calendarDays;
    public int $delayDays;
}