<?php

namespace Tg\Decimal\Calculator\LazyCalc;

use Tg\Decimal\Calculator\LazyCalc;
use Tg\Decimal\Decimal;
use Tg\Decimal\Rational;
use Tg\Decimal\ToRationalInterface;

class CalculationOperation implements CalculationOperationInterface
{
    public const OPERATION_ADD = 'OPERATION_ADD';
    public const OPERATION_SUB = 'OPERATION_SUB';
    public const OPERATION_MUL = 'OPERATION_MUL';
    public const OPERATION_DIV = 'OPERATION_DIV';
    public const OPERATION_NO_OP = 'OPERATION_NO_OP';
    public const OPERATION_POW = 'OPERATION_POW';
    public const OPERATION_MUL_SCALE_BY_SELF = 'OPERATION_MUL_SCALE_BY_SELF';
    public const OPERATION_ABS = 'OPERATION_ABS';
    public const OPERATION_ROUND = 'OPERATION_ROUND';

    /** @var CalculationOperation|null */
    private $a;

    /** @var CalculationOperation|null */
    private $b;

    /** @var toRationalInterface|null */
    private $leafValue;

    /** @var string */
    private $operation;

    /** @var string|null */
    private $hint;

    private $operationArgs = [];

    public function __construct(?CalculationOperationInterface $a, ?CalculationOperationInterface $b, string $operation, array $operationArgs = [])
    {
        $this->a = $a;
        $this->b = $b;
        $this->operation = $operation;
        $this->operationArgs = $operationArgs;
    }

    public static function newLeaf(ToRationalInterface $toRational) {
        $self = new static(null, null, self::OPERATION_NO_OP, []);
        $self->leafValue = $toRational;
        return $self;
    }

    public function isLeaf(): bool
    {
        return $this->leafValue !== null;
    }

    public function getLeafValue(): ?ToRationalInterface
    {
        return $this->leafValue;
    }

    public function getA(): ?CalculationOperationInterface
    {
        return $this->a;
    }

    public function getB(): ?CalculationOperationInterface
    {
        return $this->b;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function hint(string $hint)
    {
        $this->hint = $hint;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function getOperationArgs(): array
    {
        return $this->operationArgs;
    }
}