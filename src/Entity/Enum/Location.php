<?php

namespace App\Entity\Enum;

enum Location: string
{
    case Park = 'park';
    case Street = 'street';
    case Indoor = 'indoor';
}
