<?php

namespace Tg\Decimal;

class Rational
{
    // whole ...

    /** @var int */
    private $numerator;

    /** @var int */
    private $denominator;

    public function __construct(int $numerator, int $denominator)
    {
        $this->numerator = $numerator;
        $this->denominator = $denominator;
    }

    private static function greatestCommonDivisor(int $a, int $b): int
    {
        if ($a == 0) {
            return abs($b);
        }
        if ($b == 0) {
            return abs($a);
        }

        do {
            $h = $a % $b;
            $a = $b;
            $b = $h;
        } while ($b != 0);

        return abs($a);
    }

    public function addRational(Rational $rational): Rational
    {
        $numerator = ($this->denominator * $this->numerator) + ($rational->getDenominator() * $rational->getNumerator());

        $denominator = $this->denominator * $rational->getDenominator();

        return (new Rational($numerator, $denominator))->normalize();
    }

    public function normalize()
    {
        $greatestCommonDivisor = static::greatestCommonDivisor($this->numerator, $this->denominator);

        return new Rational($this->getNumerator() / $greatestCommonDivisor, $this->getDenominator() / $greatestCommonDivisor);
    }

    public function __toString()
    {
        return '(' . $this->numerator . ' / ' . $this->denominator . ')';
    }

    public function getNumerator(): int
    {
        return $this->numerator;
    }

    public function getDenominator(): int
    {
        return $this->denominator;
    }


}