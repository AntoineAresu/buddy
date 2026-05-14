<?php

namespace App\Twig;

use App\Entity\Enum\ReactionLevel;
use Twig\Attribute\AsTwigFunction;

class ReactionExtension
{
    #[AsTwigFunction('get_reaction_color')]
    public function getReactionColor(?ReactionLevel $reaction): string
    {
        return match ($reaction) {
            null => 'success',
            ReactionLevel::Mild, ReactionLevel::Moderate => 'warning',
            ReactionLevel::High => 'danger',
        };
    }
}
