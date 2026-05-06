<?php

namespace App\Validator\Constraints;

use App\Entity\Night;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NightDateConsistencyValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof NightDateConsistency) {
            throw new UnexpectedTypeException($constraint, NightDateConsistency::class);
        }

        $this->validateDuration($value);
        $this->validateUniqueNightPerDay($value);
    }

    private function validateDuration(mixed $value): void
    {
        /** @var Night $value */
        $duration = $value->getDurationInHours();
        $maxDuration = Night::MAX_DURATION_HOURS;

        if ($duration > $maxDuration) {
            $this->context
                ->buildViolation('night_duration_too_long')
                ->setParameter('%hour%', (string) $maxDuration)
                ->addViolation();
        }
    }

    private function validateUniqueNightPerDay(mixed $value): void
    {
        /** @var Night $value */
        $dog = $value->getDog();
        $isNightUnique = !$dog?->getNights()->exists(
            fn (int $key, Night $night) => $value !== $night && $night->getStart()?->format('Y-m-d') === $value->getStart()?->format('Y-m-d')
        );

        if (!$isNightUnique) {
            $this->context
                ->buildViolation('night_already_exists_for_day')
                ->addViolation();
        }
    }
}
