FROM php:8.3-apache-bookworm AS app

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

COPY docker/php-web/php.ini /usr/local/etc/php/php.ini
COPY src/. /var/www/html

RUN composer install --no-dev --optimize-autoloader
RUN test -f /var/www/html/public/index.php


FROM node:22-bookworm-slim AS assets

WORKDIR /app
COPY --from=app /var/www/html /app
RUN npm ci && npm run build


FROM app AS final

COPY --from=assets /app/public/build /var/www/html/public/build

RUN mkdir -p /var/www/html/storage/app/public/images && \
  rm -rf /var/www/html/public/storage && \
  ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage && \
  chown -R www-data:www-data storage bootstrap/cache public/build

RUN printf '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog /proc/self/fd/2\n\
    CustomLog /proc/self/fd/1 combined\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf && \
  echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
  a2enmod rewrite && \
  chown -R www-data:www-data storage bootstrap/cache public/build

CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]