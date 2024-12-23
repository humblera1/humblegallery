# Базовый образ
FROM php:8.2-fpm

# Установка необходимых библиотек и зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    cron \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libwebp-dev \
    sudo && \
    docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype && \
    docker-php-ext-install pdo_mysql mbstring mysqli exif pcntl bcmath gd zip opcache sockets && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

ENV PHP_IDE_CONFIG 'serverName=app'

RUN echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.client_port=9001' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.max_nesting_level=512' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.trigger_value=PHPSTORM' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo 'xdebug.log=php://stderr' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.log_level=10' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN touch /tmp/xdebug.log \
    && chown www-data:www-data /tmp/xdebug.log \
    && chmod 664 /tmp/xdebug.log

# Копируем файл конфигурации Xdebug
# COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаем пользователя в контейнере
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Указываем рабочую директорию
WORKDIR /var/www

# Копируем файлы приложения
COPY . /var/www

# Установка зависимостей Composer
# RUN composer install --optimize-autoloader
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative

# Запускаем FPM
ENTRYPOINT ["php-fpm"]