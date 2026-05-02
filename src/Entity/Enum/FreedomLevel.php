<?php

namespace App\Entity\Enum;

enum FreedomLevel: string
{
    case Leash = 'leash';
    case LongLine = 'long_line';
    case Free = 'free';
}
