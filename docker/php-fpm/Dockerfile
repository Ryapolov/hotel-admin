FROM php:7.3-fpm

RUN apt-get update && apt-get install -y wget git unzip  \
    && apt-get install --yes --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www/app