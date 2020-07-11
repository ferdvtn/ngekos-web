FROM php:7.2-apache

RUN apt-get update \
    && apt-get install --yes --no-install-recommends libpq-dev ksh zip unzip curl wget sendmail libpng-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql mysqli calendar gd zip \
	&& a2enmod rewrite

# -- Install composer --
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer
