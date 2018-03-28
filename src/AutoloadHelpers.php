<?php

namespace Tg\Decimal;

function floatish(string $value): Decimal
{
    return \Tg\Decimal\Decimal::newFloatish($value);
}