FROM composer:2 as build

COPY ./composer.json /app/composer.json
COPY ./composer.lock /app/composer.lock

RUN composer install

FROM php:8-alpine

COPY --from=build /app/vendor /var/www/html/vendor
COPY . /var/www/html

WORKDIR /var/www/html
