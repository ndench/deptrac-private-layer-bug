FROM php:8.2-cli

RUN pecl install xdebug-3.2.1 \
	&& docker-php-ext-enable xdebug
