<?php

namespace Tg\Decimal\PrettyPrinter;

use Tg\Decimal\Calculator\LazyCalc\CalculationOperation;

interface PrettyPrinterInterface
{
    public function pretty(CalculationOperation $operation): string;
}