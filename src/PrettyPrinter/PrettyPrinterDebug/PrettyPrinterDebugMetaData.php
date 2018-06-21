<?php

namespace Tg\Decimal\PrettyPrinter\PrettyPrinterDebug;

class PrettyPrinterDebugMetaData
{
    private $store = [];

    public function storeDeep($bucket, int $deep)
    {
        if (!is_object($bucket)) {
            throw new \InvalidArgumentException('invalid type');
        }

        $hash = spl_object_hash($bucket);

        if (!isset($this->store[$hash])) {
            $this->store[$hash] = [];
        }

        $this->store[$hash]['deep'] = $deep;
    }

    public function getDeep($bucket): int
    {
        if (!is_object($bucket)) {
            throw new \InvalidArgumentException('invalid type');
        }

        $hash = spl_object_hash($bucket);

        if (!isset($this->store[$hash]['deep'])) {
            $a = 0;
        }

        return $this->store[$hash]['deep'];
    }

    public function indent($bucket, int $add = 0)
    {
        return str_repeat('  ', $this->getDeep($bucket) + $add);
    }

}