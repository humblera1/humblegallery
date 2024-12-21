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
    sudo && \
    docker-php-ext-install pdo_mysql mbstring mysqli exif pcntl bcmath gd zip opcache sockets && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаем пользователя в контейнере
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Указываем рабочую директорию
WORKDIR /var/www

# Копируем файлы приложения
COPY . /var/www

# Установка зависимостей Composer
RUN composer install --no-dev --optimize-autoloader

# Запускаем FPM
ENTRYPOINT ["php-fpm"]