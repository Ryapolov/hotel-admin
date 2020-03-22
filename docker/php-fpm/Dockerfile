FROM php:7.3-fpm

RUN apt-get update && apt-get install -y wget git unzip  \
    && apt-get install --yes --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN wget https://curl.haxx.se/ca/cacert.pem \
    && mv cacert.pem /home/cacert.pem

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www/app