build: data var/logs var/cache var/sessions vendor
	#./vendor/squizlabs/php_codesniffer/scripts/phpcs --extensions=php --standard=app/standard/Clean -s src/
	#./vendor/squizlabs/php_codesniffer/scripts/phpcs --extensions=php --standard=app/standard/Clean -s tests/
	#./vendor/phpmd/phpmd/src/bin/phpmd src/ text app/standard/phpmd.xml
	#./vendor/phpmd/phpmd/src/bin/phpmd tests/ text app/standard/phpmd.xml
	php ./vendor/bin/phpunit -c .
	#php bin/console doctrine:migrations:migrate --no-interaction

vendor: composer.lock
	composer install
	touch vendor

data:
	mkdir data
	chmod -R 0777 data

var/logs:
	mkdir var/logs
	chmod -R 0777 var/logs

var/cache:
	mkdir var/cache
	chmod -R 0777 var/cache

var/sessions:
	mkdir var/sessions
	chmod -R 0777 var/sessions


.PHONY: build