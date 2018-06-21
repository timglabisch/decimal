<?php

namespace Tg\Tests\Decimal\PrettyPrinter;

use PHPUnit\Framework\TestCase;
use Tg\Decimal\PrettyPrinter\PrettyPrinterDebug;
use function Tg\Decimal\dec;
use function Tg\Decimal\lazy_calc;

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
            dec(1)->hint('val 1 ...')
        )->hint('start value...')
            ->add(
                lazy_calc(
                    dec(2)->hint('val 2 ...')
                )
                    ->add(
                        lazy_calc(
                            dec(3)->hint('val 3 ...')
                        )
                            ->add(
                                dec(4)->hint('val 4 ...')
                            )->hint('add 3 and 4')
                            ->add(
                                dec(5)->hint('val 5 ...')
                            )->hint('and add 5')
                            ->add(
                                dec(6)->hint('val 6 ...')
                            )->hint('and add 6')
                            ->add(
                                dec(7)->hint('val 7 ...')
                            )->hint('and add 7')
                    )
            );

        $a = $calc->pretty(new PrettyPrinterDebug()) . str_repeat(' ', 1000);

        $b = 0;
    }
}
