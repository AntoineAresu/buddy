<?php

namespace App\Domain\Calendar;

use App\Domain\Calendar\Crossing\CrossingDayReactionSummary;
use App\Entity\Dog;
use App\Entity\Night;
use App\Repository\CrossingRepository;
use App\Repository\NightRepository;

readonly class CalendarDataFormatter
{
    public function __construct(private NightRepository $nightRepository, private CrossingRepository $crossingRepository)
    {
    }

    /**
     * @return array<int, array<string, float|string|null>>
     */
    public function getNightsCalendarData(Dog $dog): array
    {
        $nights = $this->nightRepository->findBy(['dog' => $dog]);

        return array_map(fn (Night $night) => [
            'start' => $night->getStart()?->format('Y-m-d H:i:s'),
            'duration' => $night->getDurationInHours(),
            'end' => $night->getEnd()?->format('Y-m-d H:i:s'),
        ], $nights);
    }

    /**
     * @return list<array>
     */
    public function getCrossingsCalendarData(Dog $dog): array
    {
        $crossings = $this->crossingRepository->findBy(['dog' => $dog]);

        $summariesByDate = [];

        foreach ($crossings as $crossing) {
            $date = $crossing->getDate()->format('Y-m-d');
            $summariesByDate[$date] ??= new CrossingDayReactionSummary($crossing->getDate());
            $summariesByDate[$date]->recordCrossing(null !== $crossing->getReaction());
        }

        return array_values(array_map(
            fn (CrossingDayReactionSummary $summary) => $summary->toArray(),
            $summariesByDate
        ));
    }
}
