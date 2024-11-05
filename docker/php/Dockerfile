FROM php:8.2-fpm

RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y; \
    apt-get install -y --no-install-recommends \
            curl \
            libmemcached-dev \
            libzip-dev \
            libz-dev \
            libpq-dev \
            libfreetype6-dev \
            libssl-dev \
            libxpm-dev \
            libmcrypt-dev \
            libonig-dev \
            zlib1g-dev \
            git \
            libicu-dev \
            zip \
            libzip-dev \
            zlib1g-dev \
            unzip \
            acl

RUN set -eux \
     && docker-php-ext-install intl opcache pdo pdo_mysql \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && docker-php-ext-configure zip \
        && docker-php-ext-install zip

COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint

RUN chmod +x /usr/local/bin/docker-entrypoint

WORKDIR /var/www/bnovo

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
