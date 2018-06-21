<?php

namespace Tg\Decimal;

use Tg\Calc\LazyCalc;

function lazy_calc(ToRationalInterface $toRational): LazyCalc
{
    return new LazyCalc($toRational);
}

function rat(int $numerator, $denominator)
{
    return new Rational($numerator, $denominator);
}

function dec(string $value, $scale = null): Decimal
{
    if (null !== $scale) {
        return new Decimal($value, $scale);
    }

    return Decimal::fromStringStrict($value);
}

function floatish(string $value): Decimal
{
    return \Tg\Decimal\Decimal::newFloatish($value);
}