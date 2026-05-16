<?php

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum FreedomLevel: string implements TranslatableInterface
{
    case Leash = 'leash';
    case LongLine = 'long_line';
    case Free = 'free';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(strtolower($this->name), locale: $locale);
    }
}
