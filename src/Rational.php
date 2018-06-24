<?php

namespace Tg\Decimal;

class Rational implements ToRationalInterface, ToDecimalInterface, HasHintInterface
{
    /** @var Decimal0 */
    private $numerator;

    /** @var Decimal0 */
    private $denominator;

    /** @var ?string */
    private $hint;

    public static function fromDecimal(Decimal $decimal): Rational
    {
        $scale = $decimal->getScale();

        return (new Rational(
            dec0((string)$decimal->mul(dec0("10")->pow(dec0($scale)))),
            dec0((string)dec0('10')->pow(dec0($scale)))
        ))->normalize();
    }

    public static function fromInt(int $cnt): Rational
    {
        return new self(dec0((string)$cnt), dec0("1"));
    }

    public function __construct(Decimal0 $numerator, Decimal0 $denominator)
    {
        $this->numerator = $numerator;
        $this->denominator = $denominator;
    }

    public static function leastCommonMultiple(Decimal0 $a, Decimal0 $b): Decimal
    {
        if ($a->isZero() || $b->isZero()) {
            return dec0('0');
        }

        return $a->mul($b)->divScaleBySelf(self::greatestCommonDivisor($a, $b));
    }

    private static function greatestCommonDivisor(Decimal0 $a, Decimal0 $b): Decimal
    {
        if ($a->isZero()) {
            return $b->abs();
        }

        if ($b->isZero()) {
            return $a->abs();
        }

        do {
            $h = $a->mod($b);
            $a = $b;
            $b = $h;
        } while (!$b->isZero());

        return $a->abs();
    }

    public function addRational(Rational $rational): Rational
    {
        $lcm = static::leastCommonMultiple($this->getDenominator(), $rational->getDenominator());

        $n = $this->getNumerator()
            ->mul($lcm->divScaleBySelf($this->getDenominator()))
            ->add(
                $rational->getNumerator()->mul(
                    $lcm->divScaleBySelf($rational->getDenominator())
                )
            );

        $d = $lcm;

        return (new Rational(dec0((string)$n), dec0((string)$d)))->normalize();
    }

    public function multiplyRational(Rational $rational): Rational
    {
        return (new Rational(
            dec0((string)$rational->getNumerator()->mul($this->getNumerator())),
            dec0((string)$this->getDenominator()->mul($rational->getDenominator()))
        ))->normalize();
    }

    public function divideRational(Rational $rational): Rational
    {
        return (new Rational(
            dec0((string)$rational->getDenominator()->mul($this->getNumerator())),
            dec0((string)$this->getDenominator()->mul($rational->getNumerator()))
        ))->normalize();
    }

    public function substractRational(Rational $rational): Rational
    {
        return $this->addRational($rational->multiplyRational(Rational::fromInt(-1)));
    }

    public function normalize()
    {
        $greatestCommonDivisor = static::greatestCommonDivisor($this->numerator, $this->denominator);

        return new Rational(
            dec0((string)$this->getNumerator()->divScaleBySelf($greatestCommonDivisor)),
            dec0((string)$this->getDenominator()->divScaleBySelf($greatestCommonDivisor))
        );
    }

    public function __toString()
    {
        return '(' . $this->numerator . ' / ' . $this->denominator . ')';
    }

    public function getNumerator(): Decimal0
    {
        return $this->numerator;
    }

    public function getDenominator(): Decimal0
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