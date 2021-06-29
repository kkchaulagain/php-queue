FROM php:7.4-apache

# ======================================================= #
# ENV variable
# ======================================================= #
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
		libjpeg-dev \
        zip \
        unzip \
    && apt-get install -y git
## INSTALL SOCKETS
RUN docker-php-ext-install sockets
## INSTALL AND ENABLE xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# ======================================================= #
# MAKE DOCUMENT_ROOT WEB PROCESS WRITEABLE
# ======================================================= #

RUN chown -R www-data:www-data /var/www/html 

# ======================================================= #
# INSTALL COMPOSER
# ======================================================= #

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
