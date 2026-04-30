FROM php:8.3-fpm as php

ENV PHP_OPCACHE_ENABLE=1 
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=1
ENV PHP_OPCACHE_REVALIDATE_FREQ=1

RUN usermod -u 1000 www-data

RUN apt-get update
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev nginx
RUN docker-php-ext-install pdo pdo_mysql bcmath curl opcache intl

# COPY . /var/www
WORKDIR /var/www

COPY --chown=www-data . .

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/entrypoint.sh /entrypoint.sh
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN php artisan cache:clear
# RUN php artisan config:clear

RUN composer install --no-interaction --prefer-dist
RUN chmod -R 755 /var/www/storage
RUN chmod -R 755 /var/www/bootstrap/
RUN chmod +x /entrypoint.sh

ENTRYPOINT [ "/entrypoint.sh" ]