<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum ReactionLevel: string implements TranslatableInterface
{
    case Mild = 'mild';
    case Moderate = 'moderate';
    case High = 'high';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(strtolower($this->name), locale: $locale);
    }
}
