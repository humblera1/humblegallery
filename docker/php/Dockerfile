# Базовый образ
FROM php:8.2-fpm

# Доустановка библиотек и зависимостей
RUN apt-get update
RUN apt-get install -y \
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
    sudo

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Пользуемся утилитой базового образа
RUN docker-php-ext-install pdo_mysql \
    mbstring  \
    mysqli \
    exif  \
    pcntl  \
    bcmath  \
    gd  \
    zip \
    opcache \
    sockets

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Создаем пользователя в контейнере
#RUN useradd -G www-data,root -u 1000 -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && \
#    chown -R $user:$user /home/$user

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Указываем рабочую директорию
WORKDIR /var/www

# Запускаем FPM
ENTRYPOINT ["php-fpm"]