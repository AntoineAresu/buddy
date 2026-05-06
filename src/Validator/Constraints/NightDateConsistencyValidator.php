<?php

namespace App\Validator\Constraints;

use App\Entity\Night;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

class NightDateConsistencyValidator extends ConstraintValidator
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof NightDateConsistency) {
            throw new UnexpectedTypeException($constraint, NightDateConsistency::class);
        }

        $this->validateDuration($value);
    }

    private function validateDuration(mixed $value): void
    {
        /** @var Night $value */
        $duration = $value->getDurationInHours();
        $maxDuration = Night::MAX_DURATION_HOURS;

        if ($duration > $maxDuration) {
            $this->context
                ->buildViolation($this->translator->trans('night_duration_too_long'))
                ->setParameter('%hour%', (string) $maxDuration)
                ->addViolation();
        }
    }
}
