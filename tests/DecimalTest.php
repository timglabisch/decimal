<?php

namespace Tg\Tests\Decimal;

use PHPUnit\Framework\TestCase;
use Tg\Decimal\Decimal;
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

    /**
     * @dataProvider dataProviderAddSame
     * @dataProvider dataProviderMul
     */
    public function testSame(Decimal $a, Decimal $b)
    {
        static::assertDecimalSame($a, $b);
    }

    public function dataProviderMul()
    {
        yield [
            fl("0"),
            fl("1")->multiply(fl("0"))
        ];

        yield [
            fl("1"),
            fl("1")->multiply(fl("1"))
        ];

        yield [
            fl("0.30"),
            fl("0.10")->multiply(fl("3"))
        ];

        yield [
            fl("4"),
            fl("2")->multiply(fl("2"))
        ];

        yield [
            fl("0.000000000004"),
            fl("0.000000000002")->multiply(fl("2"))
        ];
    }
}