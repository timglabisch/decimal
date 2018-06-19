<?php

namespace Tg\Decimal;

function dec(string $value): Decimal
{
    return Decimal::fromStringStrict($value);
}

function floatish(string $value): Decimal
{
    return \Tg\Decimal\Decimal::newFloatish($value);
}