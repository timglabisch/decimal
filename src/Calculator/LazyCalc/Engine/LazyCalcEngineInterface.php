<?php

namespace Tg\Decimal\Calculator\LazyCalc\Engine;

use Tg\Decimal\Calculator\LazyCalc\CalculationOperationInterface;
use Tg\Decimal\Rational;
use Tg\Decimal\ToRationalInterface;

interface LazyCalcEngineInterface
{
    public function toRational(CalculationOperationInterface $v): toRationalInterface;

    // todo, die engine muss eine operation verarbeiten können.
}