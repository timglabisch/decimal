<?php

namespace Tg\Decimal\Calculator\LazyCalc;

use Tg\Decimal\Calculator\LazyCalc;
use Tg\Decimal\Decimal;
use Tg\Decimal\Rational;
use Tg\Decimal\ToRationalInterface;

class CalculationOperation implements ToRationalInterface
{
    public const OPERATION_ADD = 'OPERATION_ADD';
    public const OPERATION_SUB = 'OPERATION_SUB';
    public const OPERATION_MUL = 'OPERATION_MUL';
    public const OPERATION_DIV = 'OPERATION_DIV';
    public const OPERATION_NO_OP = 'OPERATION_NO_OP';

    /** @var ToRationalInterface|CalculationOperation|null */
    private $a;

    /** @var ToRationalInterface|CalculationOperation|null */
    private $b;

    /** @var string */
    private $operation;

    /** @var string|null */
    private $hint;

    public function __construct(?ToRationalInterface $a, ?ToRationalInterface $b, string $operation)
    {
        $this->a = $a;
        $this->b = $b;
        $this->operation = $operation;
    }

    public function getA(): ?ToRationalInterface
    {
        return $this->a;
    }

    public function getB(): ?ToRationalInterface
    {
        return $this->b;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function toRational(): Rational
    {
        if ($this->operation === self::OPERATION_ADD) {
            return $this->a->toRational()->addRational($this->b->toRational());
        }

        if ($this->operation === self::OPERATION_DIV) {
            return $this->a->toRational()->divideRational($this->b->toRational());
        }

        if ($this->operation === self::OPERATION_MUL) {
            return $this->a->toRational()->multiplyRational($this->b->toRational());
        }

        if ($this->operation === self::OPERATION_SUB) {
            return $this->a->toRational()->substractRational($this->b->toRational());
        }

        if ($this->operation === self::OPERATION_NO_OP) {
            return $this->a->toRational();
        }
    }

    public function toPrettyVal($val)
    {
        if ($val instanceof CalculationOperation) {
            return $val->toPretty();
        }

        if ($val instanceof LazyCalc) {
            return $val->pretty();
        }

        if ($val instanceof Rational) {
            return (string)$val;
        }

        if ($val instanceof Decimal) {
            return (string)$val;
        }

        throw new \LogicException('could not format val.');
    }

    public function toPretty()
    {
        if ($this->operation === self::OPERATION_ADD) {
            return '(' . $this->toPrettyVal($this->a) . ' + ' . $this->toPrettyVal($this->b) . ')';
        }

        if ($this->operation === self::OPERATION_DIV) {
            return '(' . $this->toPrettyVal($this->a) . ' / ' . $this->toPrettyVal($this->b) . ')';
        }

        if ($this->operation === self::OPERATION_MUL) {
            return '(' . $this->toPrettyVal($this->a) . ' * ' . $this->toPrettyVal($this->b) . ')';
        }

        if ($this->operation === self::OPERATION_SUB) {
            return '(' . $this->toPrettyVal($this->a) . ' - ' . $this->toPrettyVal($this->b) . ')';
        }

        if ($this->operation === self::OPERATION_NO_OP) {
            return $this->toPrettyVal($this->a);
        }
    }

    public function addHint(string $hint)
    {
        $this->hint = $hint;
    }

}