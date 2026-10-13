FROM php:8.3.1RC3-apache-bookworm

RUN apt-get update && \
  apt-get install -y git && \
  apt-get -y install unzip libzip-dev libicu-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev rsync libpq-dev && \
  apt-get clean && \
  docker-php-ext-install intl pdo_mysql pdo_pgsql zip bcmath opcache && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) gd exif && \
  cd /usr/bin && \
  curl -s https://getcomposer.org/installer | php && \
  ln -s /usr/bin/composer.phar /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/composer
ENV PATH=$PATH:/composer/vendor/bin

WORKDIR /var/www/html

COPY docker/php-web/apache2.conf /etc/apache2/apache2.conf
COPY docker/php-web/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php-web/php.ini /usr/local/etc/php/php.ini

COPY src/. /var/www/html

RUN composer install --no-dev --optimize-autoloader

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf && \
  a2enmod rewrite && \
  chown -R www-data:www-data storage bootstrap/cache