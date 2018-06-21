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
    public const OPERATION_ROUND = 'OPERATION_ROUND';

    /** @var ToRationalInterface|CalculationOperation|null */
    private $a;

    /** @var ToRationalInterface|CalculationOperation|null */
    private $b;

    /** @var string */
    private $operation;

    /** @var string|null */
    private $hint;

    private $operationArgs = [];

    public function __construct(?ToRationalInterface $a, ?ToRationalInterface $b, string $operation, array $operationArgs = [])
    {
        $this->a = $a;
        $this->b = $b;
        $this->operation = $operation;
        $this->operationArgs = $operationArgs;
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

        if ($this->operation === self::OPERATION_ROUND) {
            return $this->a->toRational()->toDecimal($this->operationArgs['scale'])->toRational();
        }
    }

    public function addHint(string $hint)
    {
        $this->hint = $hint;
    }

    public function getOperationArgs(): array
    {
        return $this->operationArgs;
    }


}