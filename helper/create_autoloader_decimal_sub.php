<?php

echo '<?php'."\n\n";
echo '# GENERATED, LOOK AT create_autoloader_decimal_sub.php '."\n\n";
echo 'namespace Tg\Decimal;'."\n\n";

foreach (range(0, 100) as $i) {
    echo 'function decimal'.$i.'(string $value) { return new \Tg\Decimal\Decimal($value, '.$i.'); }'."\n";
}