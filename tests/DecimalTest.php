<?php

namespace Tg\Tests\Decimal;

use PHPUnit\Framework\TestCase;
use Tg\Decimal\Decimal;
use function Tg\Decimal\decimal0;
use function Tg\Decimal\decimal1;
use function Tg\Decimal\decimal2;
use function Tg\Decimal\floatish as fl;

class DecimalTest extends TestCase
{
    private static function assertDecimalSame(Decimal $a, Decimal $b)
    {
        static::assertSame((string)$a, (string)$b);
    }

    private static function assertDecimalNotSame(Decimal $a, Decimal $b)
    {
        static::assertNotSame((string)$a, (string)$b);
    }

    public function dataProviderAddNotSame()
    {
        yield [
            fl("0.21"),
            fl("0.10")->add(fl("0.10"))
        ];
    }

    /** @dataProvider dataProviderAddNotSame */
    public function testAddNotSame(Decimal $a, Decimal $b)
    {
        static::assertDecimalNotSame($a, $b);
    }

    /**
     * @dataProvider dataProviderAddSame
     * @dataProvider dataProviderMul
     * @dataProvider dataProviderSubtract
     * @dataProvider dataProviderDiv
     */
    public function testSame(Decimal $a, Decimal $b)
    {
        static::assertDecimalSame($a, $b);
    }

    public function dataProviderAddSame()
    {
        yield [
            fl("0.20"),
            fl("0.10")->add(fl("0.10"))
        ];

        yield [
            fl("0.200"),
            fl("0.10")->add(fl("0.10"))
        ];

        yield [
            fl("1"),
            fl("0.5")->add(fl("0.5"))
        ];

        yield [
            fl("2"),
            fl("1")->add(fl("1"))
        ];

        yield [
            fl("0.000000000002"),
            fl("0.000000000001")->add(fl("0.000000000001"))
        ];
    }

    public function dataProviderSubtract()
    {
        yield [
            fl("-0.1"),
            fl("0")->sub(fl("0.1"))
        ];

        yield [
            fl("-2.9"),
            fl("0.1")->sub(fl("3"))
        ];

        yield [
            fl("-2.1"),
            fl("-3.1")->sub(fl("-1"))
        ];
    }

    public function dataProviderMul()
    {
        yield [
            fl("0"),
            fl("1")->mul(fl("0"))
        ];

        yield [
            fl("1"),
            fl("1")->mul(fl("1"))
        ];

        yield [
            fl("0.30"),
            fl("0.10")->mul(fl("3"))
        ];

        yield [
            fl("4"),
            fl("2")->mul(fl("2"))
        ];

        yield [
            fl("0.000000000004"),
            fl("0.000000000002")->mul(fl("2"))
        ];
    }

    public function dataProviderDiv()
    {
        yield [
            fl("0.3333333333333333"),
            fl("1")->div(fl("3"))
        ];
    }

    public function testPrecision()
    {
        $prec = "0.3333333333333333";

        static::assertSame(
            $prec,
            var_export(1 / 3, true)
        );

        static::assertSame(
            $prec,
            fl("1")->div(fl("3"))->__toString()
        );
    }

    public function testPrecision2()
    {
        static::assertSame(
            '33.333333333333336',
            var_export(100 / 3, true)
        );

        static::assertSame(
            '33.3333333333333333',
            fl("100")->div(fl("3"))->__toString()
        );


        static::assertSame(
            '33.3333333333333333',
            fl("100")->div(fl("3"), true)->__toString()
        );
    }

    public function testRound()
    {
        static::assertDecimalSame(
            decimal2('100.54')->round(1),
            decimal1('100.5')
        );

        static::assertDecimalSame(
            decimal2('100.55')->round(1),
            decimal1('100.6')
        );

        static::assertDecimalSame(
            decimal0('3'),
            decimal0('5')->div(decimal0('2'), true)
        );

        static::assertDecimalSame(
            decimal0('2'),
            decimal0('5')->div(decimal0('2'), false)
        );
    }
}