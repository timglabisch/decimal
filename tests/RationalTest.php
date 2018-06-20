<?php

namespace Tg\Tests\Decimal;

use PHPUnit\Framework\TestCase;
use Tg\Decimal\Rational;

class RationalTest extends TestCase
{

    public function testBasicAdd()
    {
        $rational = (new Rational(4, 10))->addRational(new Rational(2, 10));

        static::assertEquals('(3 / 5)', $rational->__toString());
    }
}