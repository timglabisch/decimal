<?php

namespace Tg\Decimal;

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