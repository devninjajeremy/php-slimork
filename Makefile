help:
	@echo "make install"

install:
	curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off
	php composer.phar update --no-dev

	chmod 777 cache/views
	chmod 777 log
	cp -Rf config/common.php.sample config/common.php
	cp -Rf config/database.php.sample config/database.php

server:
	php -S localhost:8080
