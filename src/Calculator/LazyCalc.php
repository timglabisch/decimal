<?php

namespace Tg\Decimal\Calculator;

use Tg\Decimal\Calculator\LazyCalc\CalculationOperation;
use Tg\Decimal\Calculator\LazyCalc\CalculationOperationInterface;
use Tg\Decimal\Calculator\LazyCalc\Engine\LazyCalcEngineInterface;
use Tg\Decimal\Calculator\LazyCalc\Engine\LazyCalcEngineRational;
use Tg\Decimal\PrettyPrinter\PrettyPrinterInterface;
use Tg\Decimal\PrettyPrinter\PrettyPrinterStandard;
use Tg\Decimal\Rational;
use Tg\Decimal\ToRationalInterface;

class LazyCalc implements ToRationalInterface, CalculationOperationInterface
{
    /** @var CalculationOperation */
    private $value;

    /** @param $value ToRationalInterface|CalculationOperationInterface  */
    public function __construct($value)
    {
        if ($value instanceof CalculationOperationInterface) {
            $this->value = $value;

            return;
        }

        if ($value instanceof ToRationalInterface) {
            $this->value = CalculationOperation::newLeaf($value);

            return;
        }

        throw new \InvalidArgumentException();
    }

    public function add(ToRationalInterface $value): LazyCalc
    {
        return new self(new CalculationOperation($this->value, new self($value), CalculationOperation::OPERATION_ADD));
    }

    public function sub(ToRationalInterface $value): LazyCalc
    {
        return new self(new CalculationOperation($this->value, new self($value), CalculationOperation::OPERATION_SUB));
    }

    public function mul(ToRationalInterface $value): LazyCalc
    {
        return new self(new CalculationOperation($this->value, new self($value), CalculationOperation::OPERATION_MUL));
    }

    public function div(ToRationalInterface $value): LazyCalc
    {
        return new self(new CalculationOperation($this->value, new self($value), CalculationOperation::OPERATION_DIV));
    }

    public function round(int $scale): LazyCalc
    {
        return new self(new CalculationOperation($this->value, null, CalculationOperation::OPERATION_ROUND, ['scale' => $scale]));
    }

    public function toRational(LazyCalcEngineInterface $engine = null): Rational
    {
        return $this->calculate($engine);
    }

    public function calculate(LazyCalcEngineInterface $engine = null): Rational
    {
        $engine = $engine ?? new LazyCalcEngineRational();

        return $engine->toRational($this)->toRational();
    }

    public function pretty(PrettyPrinterInterface $printer = null): string
    {
        return ($printer ?? new PrettyPrinterStandard())->pretty($this->value);
    }

    public function hint(string $hint): LazyCalc
    {
        $this->value->hint($hint);

        return $this;
    }

    public function getCalculationOperation(): CalculationOperation
    {
        return $this->value;
    }

    public function getA(): ?CalculationOperationInterface
    {
        return $this->getCalculationOperation()->getA();
    }

    public function getB(): ?CalculationOperationInterface
    {
        return $this->getCalculationOperation()->getB();
    }

    public function getOperation(): string
    {
        return $this->getCalculationOperation()->getOperation();
    }

    public function getOperationArgs()
    {
        return $this->getCalculationOperation()->getOperationArgs();
    }

    public function isLeaf(): bool
    {
        return $this->getCalculationOperation()->isLeaf();
    }

    public function getLeafValue(): ?ToRationalInterface
    {
        return $this->getCalculationOperation()->getLeafValue();
    }

}