<?php

echo '<?php' . "\n\n";
echo '# GENERATED, LOOK AT create_autoloader_decimal_sub.php ' . "\n\n";
echo 'namespace Tg\Decimal;' . "\n\n";

foreach (range(0, 100) as $i) {
    echo 'function dec' . $i . '(string $value): \Tg\Decimal\Decimal' . $i . ' { return new \Tg\Decimal\Decimal' . $i . '($value); }' . "\n";
}

foreach (range(0, 100) as $i) {
    echo 'class Decimal' . $i . ' extends \Tg\Decimal\Decimal { public function __construct(string $value) { parent::__construct($value, ' . $i . '); } }' . "\n";
}