<?php

namespace Tg\Decimal\PrettyPrinter;

use Tg\Decimal\Calculator\LazyCalc;
use Tg\Decimal\Calculator\LazyCalc\CalculationOperation;
use Tg\Decimal\Decimal;
use Tg\Decimal\Rational;

class PrettyPrinterStandard
{
    public function toPrettyVal($val)
    {
        if ($val instanceof CalculationOperation) {
            return $this->pretty($val);
        }

        if ($val instanceof LazyCalc) {
            return $this->pretty($val->getCalculationOperation());
        }

        if ($val instanceof Rational) {
            return (string)$val;
        }

        if ($val instanceof Decimal) {
            return (string)$val;
        }

        throw new \LogicException('could not format val.');
    }

    public function pretty(CalculationOperation $operation): string
    {

        if ($operation->getOperation() === CalculationOperation::OPERATION_ADD) {
            return '(' . $this->toPrettyVal($operation->getA()) . ' + ' . $this->toPrettyVal($operation->getB()) . ')';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_DIV) {
            return '(' . $this->toPrettyVal($operation->getA()) . ' / ' . $this->toPrettyVal($operation->getB()) . ')';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_MUL) {
            return '(' . $this->toPrettyVal($operation->getA()) . ' * ' . $this->toPrettyVal($operation->getB()) . ')';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_SUB) {
            return '(' . $this->toPrettyVal($operation->getA()) . ' - ' . $this->toPrettyVal($operation->getB()) . ')';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_NO_OP) {
            return $this->toPrettyVal($operation->getA());
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_ROUND) {
            return 'round(' . $this->toPrettyVal($operation->getA()) . ', scale = ' . $operation->getOperationArgs()['scale'] . ')';
        }

        throw new \LogicException('could not pretty operation');
    }
}