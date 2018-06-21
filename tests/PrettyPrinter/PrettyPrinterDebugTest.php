<?php

namespace Tg\Tests\Decimal\PrettyPrinter;

use PHPUnit\Framework\TestCase;
use function Tg\Decimal\dec;
use function Tg\Decimal\lazy_calc;
use Tg\Decimal\PrettyPrinter\PrettyPrinterDebug;

class PrettyPrinterDebugTest extends TestCase
{
    public function testPrettyPrintDebug()
    {
        /*
        $calc = lazy_calc(
            lazy_calc(
                dec(1)
            )->add(
                dec(2)
            )
        )->add(
            lazy_calc(
                dec(3)
            )->add(
                dec(4)
            )
        );
        */

        $calc = lazy_calc(
            dec(1)
        )->add(
            lazy_calc(dec(2))
                ->add(
                    lazy_calc(dec(3))
                        ->add(dec(4))
                        ->add(dec(5))
                        ->add(dec(6))
                        ->add(dec(7))
                )
        );

        $a = $calc->pretty(new PrettyPrinterDebug()). str_repeat(' ', 1000);

        $b = 0;
    }
}
