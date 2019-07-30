<?php


namespace Tg\Decimal\Calculator\LazyCalc;


use Tg\Decimal\Calculator\LazyCalc\LazyCalcWalker\LazyCalcWalkerEntry;

class LazyCalcWalker
{
    private function walk(CalculationOperationInterface $current, $deep, \ArrayObject $calcEntries)
    {
        $entry = new LazyCalcWalkerEntry($deep, $current);

        $calcEntries[spl_object_id($current)] = $entry;

        // leafs are already calculated, so we can set the value.
        if ($current->isLeaf()) {
            $entry->setValue($current->getLeafValue());
            return;
        }

        if ($current->getA()) {
            $this->walk($current->getA(), $deep + 1, $calcEntries);
        }

        if ($current->getB()) {
            $this->walk($current->getB(), $deep + 1, $calcEntries);
        }
    }

    public function getOps(CalculationOperationInterface $root): array
    {
        $calcEntries = new \ArrayObject();

        $this->walk($root, 0, $calcEntries);

        /** @var $calcEntries LazyCalcWalkerEntry[] */
        $calcEntries = $calcEntries->getArrayCopy();

        uasort($calcEntries, function(LazyCalcWalkerEntry $a, LazyCalcWalkerEntry $b) {
            return $b->getDeep() <=> $a->getDeep();
        });

        $toCalculates = $calcEntries;

        foreach ($calcEntries as $calcEntry) {
            if (!$calcEntry->getValue()) {
                continue;
            }

            unset($toCalculates[spl_object_id($calcEntry->getNode())]);
        }

        foreach ($toCalculates as $toCalculate) {
            $this->foo($calcEntries, $toCalculate);
        }

        return [];
    }

    /**
     * @param LazyCalcWalkerEntry[] $calcEntries
     * @param LazyCalcWalkerEntry $calcEntry
     */
    private function foo(array $calcEntries, LazyCalcWalkerEntry $calcEntry)
    {
        if ($calcEntries[spl_object_id($calcEntry->getNode())]) {
            throw new \LogicException('already calculated.');
        }

        $calculatedA = $calcEntry->getNode()->getA() ? $calcEntries[spl_object_id($calcEntry->getNode()->getA())]->getValue() : null;
        $calculatedB = $calcEntry->getNode()->getB() ? $calcEntries[spl_object_id($calcEntry->getNode()->getB())]->getValue() : null;

        if (!$calculatedA || !$calculatedB) {
            throw new \LogicException('A and B must be calculated.');
        }

        $a = 0;
    }
}