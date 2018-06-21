<?php

namespace Tg\Decimal;

interface HasHintInterface
{
    /** @return static */
    public function hint(string $hint);

    public function getHint(): ?string;
}