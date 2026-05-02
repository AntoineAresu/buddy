<?php

namespace App\Entity\Enum;

enum ReactionLevel: string
{
    case Mild = 'mild';
    case Moderate = 'moderate';
    case High = 'high';
}
