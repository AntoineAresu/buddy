<?php

namespace App\Domain\Calendar\Crossing;

class CrossingDayReactionSummary
{
    public int $reactionCount = 0;
    public int $noReactionCount = 0;

    public function __construct(public readonly \DateTime $date)
    {
    }

    public function recordCrossing(bool $hasReaction): void
    {
        $hasReaction ? $this->reactionCount++ : $this->noReactionCount++;
    }

    /**
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'reactionCount' => $this->reactionCount,
            'noReactionCount' => $this->noReactionCount,
        ];
    }
}
