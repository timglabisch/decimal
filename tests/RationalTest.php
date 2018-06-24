<?php

namespace Tg\Tests\Decimal;

use PHPUnit\Framework\TestCase;
use function Tg\Decimal\dec0;
use Tg\Decimal\Decimal;
use Tg\Decimal\Decimal1;
use Tg\Decimal\Decimal10;
use function Tg\Decimal\rat;
use Tg\Decimal\Rational;

class RationalTest extends TestCase
{
    /**
     * @dataProvider dataProviderBasicMultiply
     * @dataProvider dataProviderBasicAdd
     * @dataProvider dataProviderBasicDivide
     * @dataProvider dataProviderBasicSubstract
     * @dataProvider dataProviderFromDecimal
     */
    public function testSameString(string $s, Rational $rational)
    {
        static::assertSame($s, $rational->__toString());
    }

    public function dataProviderBasicAdd()
    {
        yield [
            '(3 / 5)',
            (new Rational(dec0(4), dec0(10)))->addRational(new Rational(dec0(2), dec0(10)))
        ];

        yield [
            '(13 / 24)',
            (new Rational(dec0(3), dec0(8)))->addRational(new Rational(dec0(1), dec0(6)))
        ];
    }

    public function dataProviderBasicMultiply()
    {
        yield [
            '(3 / 10)',
            (new Rational(dec0(2), dec0(5)))->multiplyRational(new Rational(dec0(6), dec0(8)))
        ];
    }

    public function dataProviderBasicDivide()
    {
        yield [
            '(14 / 15)',
            (new Rational(dec0(2), dec0(3)))->divideRational(new Rational(dec0(5), dec0(7)))
        ];
    }

    public function dataProviderBasicSubstract()
    {
        yield [
            '(9 / 4)',
            (new Rational(dec0(15), dec0(4)))->substractRational(new Rational(dec0(6), dec0(4)))
        ];
    }

    public function dataProviderFromDecimal()
    {
        yield [
            '(1 / 1)',
            Rational::fromDecimal(new Decimal("1", 1))
        ];


        yield [
            '(33 / 10)',
            Rational::fromDecimal(new Decimal1("3.3"))
        ];

        yield [
            '(33333333333 / 10000000000)',
            Rational::fromDecimal(new Decimal10("3.3333333333"))
        ];
    }

    public function testToDecimal()
    {
        static::assertSame(
            "0",
            rat(1, 3)->toDecimal(0)->__toString()
        );

        static::assertSame(
            "0.3",
            rat(1, 3)->toDecimal(1)->__toString()
        );

        static::assertSame(
            "0.33",
            rat(1, 3)->toDecimal(2)->__toString()
        );

        static::assertSame(
            "1",
            rat(2, 3)->toDecimal(0)->__toString()
        );

        static::assertSame(
            "0.67",
            rat(2, 3)->toDecimal(2)->__toString()
        );

        static::assertSame(
            "0.6666666667",
            rat(2, 3)->toDecimal(10)->__toString()
        );
    }
}