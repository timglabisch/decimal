build_stub:
	php helper/create_autoloader_decimal_sub.php > src/AutoloadGeneratedHelpers.php

test: build_stub
	xdebug ./vendor/phpunit/phpunit/phpunit -c .