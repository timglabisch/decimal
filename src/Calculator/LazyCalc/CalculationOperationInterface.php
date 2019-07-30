<?php

namespace Tg\Decimal\Calculator\LazyCalc;

use Tg\Decimal\ToRationalInterface;

interface CalculationOperationInterface
{
    public function getA(): ?CalculationOperationInterface;

    public function getB(): ?CalculationOperationInterface;

    public function getOperation(): string;

    public function getOperationArgs();

    public function isLeaf(): bool;

    public function getLeafValue(): ?ToRationalInterface;
}