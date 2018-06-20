<?php

namespace Tg\Tests\Decimal;

use PHPUnit\Framework\TestCase;
use Tg\Decimal\Rational;

class RationalTest extends TestCase
{
    /**
     * @dataProvider dataProviderBasicMultiply
     * @dataProvider dataProviderBasicAdd
     * @dataProvider dataProviderBasicDivide
     * @dataProvider dataProviderBasicSubstract
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
}