<?php

namespace Tg\Decimal\Calculator\LazyCalc\LazyCalcWalker;

use Tg\Decimal\Calculator\LazyCalc\CalculationOperationInterface;
use Tg\Decimal\ToRationalInterface;

class LazyCalcWalkerEntry
{
    /** @var int */
    private $deep;

    /** @var CalculationOperationInterface|toRationalInterface */
    private $node;

    /** @var ToRationalInterface */
    private $value;

    /**
     * @param $node CalculationOperationInterface|toRationalInterface
     */
    public function __construct(int $deep, $node)
    {
        $this->deep = $deep;
        $this->node = $node;
    }

    public function getDeep(): int
    {
        return $this->deep;
    }

    /** @return CalculationOperationInterface|ToRationalInterface */
    public function getNode()
    {
        return $this->node;
    }

    public function getValue(): ?ToRationalInterface
    {
        return $this->value;
    }

    public function setValue(ToRationalInterface $value): void
    {
        $this->value = $value;
    }

}