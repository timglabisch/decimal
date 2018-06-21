<?php

namespace Tg\Decimal\PrettyPrinter;

use Tg\Decimal\Calculator\LazyCalc;
use Tg\Decimal\Calculator\LazyCalc\CalculationOperation;
use Tg\Decimal\Decimal;
use Tg\Decimal\PrettyPrinter\PrettyPrinterDebug\PrettyPrinterDebugMetaData;
use Tg\Decimal\Rational;

class PrettyPrinterDebug implements PrettyPrinterInterface
{
    private function toPrettyVal($val, PrettyPrinterDebugMetaData $metaData)
    {
        if ($val instanceof CalculationOperation) {

            $out = '';

            if ($val->getHint()) {
                $out .= "\n" . $metaData->indent($val) . '  // ' . $val->getHint();
            }

            $out .= $this->pretty($val, $metaData);

            return $out;
        }

        if ($val instanceof LazyCalc) {
            return $this->pretty($val->getCalculationOperation(), $metaData);
        }

        if ($val instanceof Rational) {
            return "\n" . $metaData->indent($val) . (string)$val . ($val->getHint() === null ? '' : '  // ' . $val->getHint());
        }

        if ($val instanceof Decimal) {
            return "\n" . $metaData->indent($val) . (string)$val . ($val->getHint() === null ? '' : '  // ' . $val->getHint());
        }

        throw new \LogicException('could not format val.');
    }

    private function createMetaData($operation, PrettyPrinterDebugMetaData $metaData = null, int $deep = 0)
    {
        if ($metaData === null) {
            $metaData = new PrettyPrinterDebugMetaData();
        }

        if ($operation instanceof CalculationOperation) {

            if ($operation->getOperation() === CalculationOperation::OPERATION_NO_OP) {
                $deep--;
            }

            if ($operation->getA() !== null) {
                $this->createMetaData($operation->getA(), $metaData, $deep + 1);
            }

            if ($operation->getB() !== null) {
                $this->createMetaData($operation->getB(), $metaData, $deep + 1);
            }

            $metaData->storeDeep($operation, $deep);
        }

        if ($operation instanceof Decimal) {
            $metaData->storeDeep($operation, $deep);
        }

        if ($operation instanceof Rational) {
            $metaData->storeDeep($operation, $deep);
        }

        if ($operation instanceof LazyCalc) {
            $metaData->storeDeep($operation, $deep + 1);
            $this->createMetaData($operation->getCalculationOperation(), $metaData, $deep + 1);
        }


        return $metaData;
    }

    public function pretty2SideOperationOperator(CalculationOperation $operation, PrettyPrinterDebugMetaData $metaData): string
    {
        if ($operation->getOperation() === CalculationOperation::OPERATION_ADD) {
            return "\n" . $metaData->indent($operation, 1) . '+';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_DIV) {
            return "\n" . $metaData->indent($operation, 1) . '/';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_MUL) {
            return "\n" . $metaData->indent($operation, 1) . '*';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_SUB) {
            return "\n" . $metaData->indent($operation, 1) . '-';
        }

        throw new \InvalidArgumentException();
    }

    public function pretty(CalculationOperation $operation, PrettyPrinterDebugMetaData $metaData = null): string
    {
        if ($metaData === null) {
            $metaData = $this->createMetaData($operation);
        }

        if (\in_array(
            $operation->getOperation(),
            [
                CalculationOperation::OPERATION_ADD,
                CalculationOperation::OPERATION_DIV,
                CalculationOperation::OPERATION_MUL,
                CalculationOperation::OPERATION_SUB,
            ]
        )) {
            return
                "\n" . $metaData->indent($operation) . '(' .
                $this->toPrettyVal($operation->getA(), $metaData) .
                $this->pretty2SideOperationOperator($operation, $metaData) .
                $this->toPrettyVal($operation->getB(), $metaData) .
                "\n" . $metaData->indent($operation) . ')';
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_NO_OP) {
            return $this->toPrettyVal($operation->getA(), $metaData);
        }

        if ($operation->getOperation() === CalculationOperation::OPERATION_ROUND) {
            return 'round(' . $this->toPrettyVal($operation->getA(), $metaData) . ', scale = ' . $operation->getOperationArgs()['scale'] . ')';
        }

        throw new \LogicException('could not pretty operation ' . $operation->getOperation());
    }


}