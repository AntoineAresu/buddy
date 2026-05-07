<?php

namespace App\Tests\Validator;

use App\Entity\Dog;
use App\Entity\Night;
use App\Validator\Constraints\NightDateConsistency;
use App\Validator\Constraints\NightDateConsistencyValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Symfony\Component\Validator\ConstraintValidatorInterface;

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
        var_dump($this->context->getViolations());
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
}
