current_dir = $(shell pwd)

build_stub:
	php helper/create_autoloader_decimal_sub.php > src/AutoloadGeneratedHelpers.php

test: build_stub
	xdebug ./vendor/phpunit/phpunit/phpunit -c .

test74:
	docker run --rm -v $(current_dir):/app -w /app php74-decimal vendor/bin/phpunit

test80:
	docker run --rm -v $(current_dir):/app -w /app php80-decimal vendor/bin/phpunit

docker-build:
	docker build -t php74-decimal Docker/php74
	docker build -t php80-decimal Docker/php80