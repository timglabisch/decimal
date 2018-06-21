<?php

namespace Tg\Decimal;

class Rational implements ToRationalInterface, ToDecimalInterface, HasHintInterface
{
    /** @var int */
    private $numerator;

    /** @var int */
    private $denominator;

    /** @var ?string */
    private $hint;

    public static function fromDecimal(Decimal $decimal): Rational
    {
        $scale = $decimal->getScale();

        // hoch rechnen
        return (new Rational($decimal->getValue() * (10 ** $scale), 10 ** $scale))->normalize();
    }

    public static function fromInt(int $cnt): Rational
    {
        return new self($cnt, 1);
    }

    public function __construct(int $numerator, int $denominator)
    {
        $this->numerator = $numerator;
        $this->denominator = $denominator;
    }

    public static function leastCommonMultiple(int $a, int $b): int
    {
        if ($a === 0 || $b === 0) {
            return 0;
        }

        return abs($a * $b) / self::greatestCommonDivisor($a, $b);
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
        $lcm = static::leastCommonMultiple($this->getDenominator(), $rational->getDenominator());

        $n = $this->getNumerator() * intdiv($lcm, $this->getDenominator()) + $rational->getNumerator() * intdiv($lcm, $rational->getDenominator());
        $d = $lcm;

        return (new Rational($n, $d))->normalize();
    }

    public function multiplyRational(Rational $rational): Rational
    {
        return (new Rational(
            $rational->getNumerator() * $this->getNumerator(),
            $this->getDenominator() * $rational->getDenominator()
        ))->normalize();
    }

    public function divideRational(Rational $rational): Rational
    {
        return (new Rational(
            $rational->getDenominator() * $this->getNumerator(),
            $this->getDenominator() * $rational->getNumerator()
        ))->normalize();
    }

    public function substractRational(Rational $rational): Rational
    {
        return $this->addRational($rational->multiplyRational(Rational::fromInt(-1)));
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

    public function toRational(): Rational
    {
        return $this;
    }

    public function toDecimal(int $scale): Decimal
    {
        return (new Decimal($this->getNumerator(), $scale + 1))
            ->divScaleBySelf(new Decimal($this->getDenominator(), $scale + 1))
            ->round($scale)
            ;
    }

    public function hint(string $hint)
    {
        $this->hint = $hint;
        return $this;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }
}