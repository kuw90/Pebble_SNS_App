FROM php:8.3.1RC3-apache-bookworm

RUN apt-get update && \
  apt-get install -y git && \
  apt-get -y install unzip libzip-dev libicu-dev libonig-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev rsync libpq-dev && \
  apt-get clean && \
  docker-php-ext-install intl pdo_mysql pdo_pgsql zip bcmath opcache && \
  pecl install xdebug && \
  docker-php-ext-enable xdebug && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) gd exif && \
  # install composer
  cd /usr/bin && \
  curl -s http://getcomposer.org/installer | php && \
  ln -s /usr/bin/composer.phar /usr/bin/composer && \
  # install Node.js, npm
  apt install nodejs npm -y

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# 1. 作業ディレクトリを先に定義します
WORKDIR /var/www/html

# 2. app1フォルダの中身を、ズレなくカレントディレクトリ（/var/www/html）に展開します
COPY app1/. .

# 3. 正しいフォルダ位置でcomposer installを実行します
RUN composer install --no-dev --optimize-autoloader

# 4. 設定ファイルをコピーします
COPY app1/docker/php-web/apache2.conf /etc/apache2/apache2.conf
COPY app1/docker/php-web/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY app1/docker/php-web/php.ini /usr/local/etc/php/php.ini

# ApacheのドキュメントルートをLaravelのpublicフォルダ（本番用）に上書き強制します
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf