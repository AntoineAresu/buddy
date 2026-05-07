<?php

namespace App\Tests\Validator;

use App\Entity\Dog;
use App\Entity\Night;
use App\Validator\Constraints\NightDateConsistency;
use App\Validator\Constraints\NightDateConsistencyValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NightDateConsistencyValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new NightDateConsistencyValidator();
    }

    #[DataProvider('provideTestValidateUniqueNightPerDay')]
    public function testValidateUniqueNightPerDay(
        bool $shouldRaiseViolation,
        \DateTime $existingNightStart,
        \DateTime $existingNightEnd,
        \DateTime $newNightStart,
        \DateTime $newNightEnd,
    ): void {
        $dog = new Dog()->addNight(new Night()
            ->setStart($existingNightStart)
            ->setEnd($existingNightEnd));

        $newNight = new Night()
            ->setStart($newNightStart)
            ->setEnd($newNightEnd);

        $dog->addNight($newNight);

        $this->validator->validate($newNight, new NightDateConsistency());
        $violation = $this->buildViolation('night_already_exists_for_day');

        $shouldRaiseViolation ? $violation->assertRaised() : $this->assertNoViolation();
    }

    public static function provideTestValidateUniqueNightPerDay(): \Generator
    {
        $todayMorning = new \DateTime()->setTime(8, 00);
        $yesterdayEvening = new \DateTime('yesterday')->setTime(20, 00);
        $yesterdayMinusOneDayMorning = new \DateTime('yesterday')->sub(new \DateInterval('P1D'))->setTime(8, 00);
        $yesterdayMinusTwoDayEvening = new \DateTime('yesterday')->sub(new \DateInterval('P2D'))->setTime(20, 00);

        yield 'Should raise violation with nights on same day' => [true, $yesterdayEvening, $todayMorning, $yesterdayEvening, $todayMorning];
        yield 'Should not raise violation with nights on different days' => [false, $yesterdayMinusTwoDayEvening, $yesterdayMinusOneDayMorning, $yesterdayEvening, $todayMorning];
    }

    #[DataProvider('provideTestNightDuration')]
    public function testNightDuration(bool $shouldRaiseViolation, \DateTime $start, \DateTime $end): void
    {
        $night = new Night()
            ->setStart($start)
            ->setEnd($end);

        $this->validator->validate($night, new NightDateConsistency());

        if ($shouldRaiseViolation) {
            $violation = $this->buildViolation('night_duration_too_long')
                ->setParameter('%hour%', Night::MAX_DURATION_HOURS);

            var_dump($this->context->getViolations());
            $violation->assertRaised();
        } else {
            $this->assertNoViolation();
        }
    }

    public static function provideTestNightDuration(): \Generator
    {
        yield 'Should raise violation with duration greater than 15 hours' => [
            true,
            new \DateTime('yesterday')->setTime(20, 00),
            new \DateTime()->setTime(12, 00),
        ];
        yield 'Should not raise violation with duration same as 15 hours' => [
            false,
            new \DateTime('yesterday')->setTime(20, 00),
            new \DateTime()->setTime(8, 00),
        ];
        yield 'Should not raise violation with duration lesser than 15 hours' => [
            false,
            new \DateTime('yesterday')->setTime(20, 00),
            new \DateTime()->setTime(7, 00),
        ];
    }
}
