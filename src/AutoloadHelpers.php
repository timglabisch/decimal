<?php

namespace Tg\Decimal;

use Tg\Decimal\Calculator\LazyCalc;

function lazy_calc(ToRationalInterface $toRational): LazyCalc
{
    return new LazyCalc($toRational);
}

/**
 * @param \int|Decimal0 $numerator
 * @param \int|Decimal0 $denominator
 * @return Rational
 */
function rat($numerator, $denominator)
{
    if (is_int($numerator)) {
        $numerator = dec0($numerator);
    }
    if (is_int($denominator)) {
        $denominator = dec0($denominator);
    }

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