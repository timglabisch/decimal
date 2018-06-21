<?php

namespace Tests\Tg\Calc\Calculator;

use PHPUnit\Framework\TestCase;
use function Tg\Decimal\dec;
use function Tg\Decimal\lazy_calc;
use function Tg\Decimal\rat;

class LazyCalcTest extends TestCase
{
    public function testFoo()
    {
        $calculation = lazy_calc(dec(0))
            ->add(dec(10))// 10
            ->add(dec(10))// 20
            ->add(rat(2, 3))// 0,6667
            ->mul(dec(2));;


        static::assertSame(
            '(124 / 3)',
            $calculation->calculate()->__toString()
        );


        //$p = $calculation->pretty();
    }

    public function testFoo2()
    {
        $calculation =
            lazy_calc(dec(3))
                ->mul(lazy_calc(dec(1))->add(dec(2)));

        static::assertSame(
            '(3 * (1 + 2))',
            $calculation->pretty()
        );

        static::assertSame(
            '(9 / 1)',
            $calculation->calculate()->__toString()
        );
    }

    public function testHints()
    {
        $calculation = lazy_calc(dec(0))
            ->add(dec(10))->hint('add value 1')
            ->add(dec(10))->hint('add value 2')
            ->add(rat(2, 3))->hint('add value 2/3')
            ->mul(dec(2))->hint('mul with 2');

        $this->assertTrue(true); // not yet fully finished, debug formatter is missing.
    }

    public function testRound()
    {
        $calculation = lazy_calc(dec(0))
            ->add(lazy_calc(rat(1, 3))->round(2))
            ->add(lazy_calc(rat(1, 3))->round(2))
            ->add(lazy_calc(rat(1, 3))->round(3));

        static::assertSame(
            '(((0 + round((1 / 3), scale = 2)) + round((1 / 3), scale = 2)) + round((1 / 3), scale = 3))',
            $calculation->pretty()
        );

        static::assertTrue(
            dec('0.99300')->equals($calculation->calculate()->toDecimal(5))
        );
    }
}
