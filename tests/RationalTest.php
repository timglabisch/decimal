<?php

namespace Tg\Tests\Decimal;

use PHPUnit\Framework\TestCase;
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
            (new Rational(4, 10))->addRational(new Rational(2, 10))
        ];

        yield [
            '(13 / 24)',
            (new Rational(3, 8))->addRational(new Rational(1, 6))
        ];
    }

    public function dataProviderBasicMultiply()
    {
        yield [
            '(3 / 10)',
            (new Rational(2, 5))->multiplyRational(new Rational(6, 8))
        ];
    }

    public function dataProviderBasicDivide()
    {
        yield [
            '(14 / 15)',
            (new Rational(2, 3))->divideRational(new Rational(5, 7))
        ];
    }

    public function dataProviderBasicSubstract()
    {
        yield [
            '(9 / 4)',
            (new Rational(15, 4))->substractRational(new Rational(6, 4))
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