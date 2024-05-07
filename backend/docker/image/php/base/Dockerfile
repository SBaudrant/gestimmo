FROM php:8.2-fpm-alpine

RUN mkdir /var/composer
ENV COMPOSER_HOME /var/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV MOUNT_DIR /srv/php

RUN mkdir -p ${MOUNT_DIR}
WORKDIR ${MOUNT_DIR}

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    zip \
    opcache \
    pdo pdo_pgsql \
    bcmath \
    intl

RUN apk add --update --no-cache curl git unzip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./conf.d/timezone.ini /usr/local/etc/php/conf.d/
COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./php-fpm.d/default.conf /usr/local/etc/php-fpm.d/www.conf

RUN install-php-extensions xdebug

COPY xdebug/xdebug.ini $PHP_INI_DIR/conf.d/

EXPOSE 9000
