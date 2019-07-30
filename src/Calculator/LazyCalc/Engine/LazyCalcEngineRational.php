<?php

namespace Tg\Decimal\Calculator\LazyCalc\Engine;

use Tg\Decimal\Calculator\LazyCalc\CalculationOperation;
use Tg\Decimal\Calculator\LazyCalc\CalculationOperationInterface;
use Tg\Decimal\Calculator\LazyCalc\LazyCalcWalker;
use Tg\Decimal\ToRationalInterface;

class LazyCalcEngineRational implements LazyCalcEngineInterface
{
    public function toRational(CalculationOperationInterface $v): toRationalInterface
    {
        $operation = $v->getOperation();

        /** @var CalculationOperationInterface $a */
        $a = $v->getA();

        /** @var CalculationOperationInterface $b */
        $b = $v->getB();

        $calculationMap = new \ArrayObject();

        $a = (new LazyCalcWalker())->getOps($v);

        $ops = $this->walk($v, 0, $calculationMap);


        /*
        if ($v->isLeaf()) {
            return $v->getLeafValue();
        }

        if ($operation === CalculationOperation::OPERATION_ADD) {
            return $a->toRational()->addRational($b->toRational());
        }

        if ($operation === CalculationOperation::OPERATION_DIV) {
            return $a->toRational()->divideRational($b->toRational());
        }

        if ($operation === CalculationOperation::OPERATION_MUL) {
            return $a->toRational()->multiplyRational($b->toRational());
        }

        if ($operation === CalculationOperation::OPERATION_SUB) {
            return $a->toRational()->substractRational($b->toRational());
        }

        if ($operation === CalculationOperation::OPERATION_NO_OP) {
            return $a->toRational();
        }

        if ($operation === CalculationOperation::OPERATION_ROUND) {
            return $a->toRational()->toDecimal($v->getOperationArgs()['scale'])->toRational();
        }
        */
    }


}