FROM php:7.4-fpm-alpine

# run update
RUN apk upgrade && apk update

# install build dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS

# install application framework php extensions
RUN docker-php-ext-install \
    bcmath

# install xdebug
RUN pecl install xdebug-2.9.2 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_mode=req" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# uninstall build dependencies
RUN apk del -f .build-deps