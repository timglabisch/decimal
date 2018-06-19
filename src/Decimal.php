<?php

namespace Tg\Decimal;

use InvalidArgumentException;


class Decimal
{
    /** @var string */
    private $value;

    /** @var int */
    private $scale;

    public function __construct(string $value, int $scale)
    {
        $this->value = static::createNewNumber($value, $scale);
        $this->scale = $scale;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function __invoike(string $value)
    {
        return static::newFloatish($value);
    }

    public static function newFloatish(string $value): Decimal
    {
        return new Decimal($value, ini_get('precision') + 2);
    }

    private static function calculateMaxScale(Decimal $a, Decimal $b)
    {
        return max($a->getScale(), $b->getScale());
    }

    public function getScale(): int
    {
        return $this->scale;
    }

    private static function createNewNumber($numeric, int $scale)
    {
        if ($numeric instanceof Decimal) {
            return $numeric;
        }

        if (!is_numeric($numeric)) {
            throw new \LogicException('invalid number');
        }

        if (is_float($numeric)) {
            return number_format($numeric, $scale, '.', '');
        }

        return bcadd($numeric, '0', $scale);
    }

    public function add(Decimal $addend): Decimal
    {
        $scale = static::calculateMaxScale($this, $addend);
        $amount = bcadd($this->getValue(), $addend->getValue(), $scale);

        return new Decimal($amount, $scale);
    }

    public function sub(Decimal $subtrahend): Decimal
    {
        $scale = static::calculateMaxScale($this, $subtrahend);
        $amount = bcsub($this->getValue(), $subtrahend->getValue(), $scale);

        return new Decimal($amount, $scale);
    }

    public function mul($multiplier, bool $round = false): Decimal
    {
        $scale = $round ? $this->getScale() + 1 : $this->getScale();

        $multiplier = static::createNewNumber($multiplier, $scale);

        $amount = bcmul($this->getValue(), $multiplier, $scale);

        $decimal = new Decimal($amount, $scale);

        return $round ? $decimal->round($scale - 1) : $decimal;
    }

    public function div($divisor, bool $round = false): Decimal
    {
        $scale = $round ? $this->getScale() + 1 : $this->getScale();


        $divisor = self::createNewNumber($divisor, $scale);
        if (0 === bccomp($divisor, '0', $scale)) {
            throw new InvalidArgumentException('Divisor cannot be 0.');
        }
        $amount = bcdiv($this->getValue(), $divisor, $scale);

        $decimal = new Decimal($amount, $scale);

        return $round ?
            $decimal->round(--$scale) :
            $decimal;
    }

    public function isNegative(): bool
    {
        return bccomp($this->getValue(), '0', $this->getScale()) === -1;
    }

    public function isPositive(): bool
    {
        return bccomp($this->getValue(), '0', $this->getScale()) === 1;
    }

    public function isZero(): bool
    {
        return bccomp($this->getValue(), '0', $this->getScale()) === 0;
    }

    public function round(int $scale = 0): Decimal
    {
        $add = '0.' . str_repeat('0', $scale) . '5';
        if ($this->isNegative()) {
            $add = '-' . $add;
        }
        $newAmount = bcadd($this->getValue(), $add, $scale);

        return new Decimal($newAmount, $scale);
    }

    public function equals(Decimal $decimal)
    {
        $maxScale = self::calculateMaxScale($this, $decimal);

        return (string)(new Decimal($this->getValue(), $maxScale)) === (string)(new Decimal($decimal->getValue(), $maxScale));
    }

    /**
     * if you've a Decimal6 like 1.110000 it would fit in a Decimal2.
     * this function will turn the Decimal6 to a Decimal2
     *
     * @return Decimal
     */
    public function reduceScale()
    {
        if (($pos = strpos($this->getValue(), '.')) === false) {
            return $this;
        }

        $decimal = rtrim(substr($this->getValue(), $pos + 1), '0');

        return new Decimal(substr($this->getValue(), 0, $pos) . '.' . $decimal, strlen($decimal));
    }

    public function __toString()
    {
        return $this->getValue();
    }
}