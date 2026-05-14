<?php

namespace App\Twig;

use Twig\Attribute\AsTwigFilter;
use Twig\Attribute\AsTwigFunction;

class DateExtension
{
    #[AsTwigFunction('previous_day')]
    public function previousDay(\DateTime $date): \DateTime
    {
        return (clone $date)->modify('-1 day');
    }

    #[AsTwigFunction('next_day')]
    public function nextDay(\DateTime $date): \DateTime
    {
        return (clone $date)->modify('+1 day');
    }

    #[AsTwigFilter('date_ymd')]
    public function dateYmd(?\DateTimeInterface $date): string
    {
        return $date?->format('Y-m-d') ?? '';
    }
}
