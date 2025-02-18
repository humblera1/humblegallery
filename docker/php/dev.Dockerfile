FROM php:8.2-fpm-alpine

RUN apk --no-cache add \
  git \
  curl \
  zip \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  libwebp-dev \
  libxml2-dev \
  libzip-dev \
  oniguruma-dev \
  icu-dev \
  autoconf \
  make \
  gcc \
  g++ \
  linux-headers

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring mysqli exif pcntl bcmath gd zip opcache sockets intl \
    && pecl install xdebug && docker-php-ext-enable xdebug

# переменная окружения для Xdebug
ENV PHP_IDE_CONFIG 'serverName=app-dev'

COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www