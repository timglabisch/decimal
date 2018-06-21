<?php

namespace Tg\Decimal;

interface ToDecimalInterface
{
    public function toDecimal(int $scale) : Decimal;
}