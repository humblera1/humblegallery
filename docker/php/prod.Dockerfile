# Stage 1: Build Stage
FROM node:23.6.1-alpine AS node-build

WORKDIR /var/www

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

# Stage 2: PHP Composer Build Stage
FROM php:8.2-fpm-alpine AS php-build

RUN apk --no-cache add \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    freetype-dev \
    git \
    curl \
    zip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libxml2-dev \
    libzip-dev \
    zlib-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN composer install --no-dev --optimize-autoloader --classmap-authoritative

# Stage 3: Production Stage
FROM php:8.2-fpm-alpine

RUN apk --no-cache add \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    freetype-dev \
    linux-headers \
    libpng \
    libjpeg-turbo \
    freetype \
    libwebp \
    libxml2 \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install pdo_mysql mbstring mysqli exif pcntl bcmath gd zip opcache sockets intl

RUN addgroup -g 1000 -S phpuser \
    && adduser -u 1000 -G phpuser -s /bin/sh -D phpuser

WORKDIR /var/www

COPY --from=php-build /var/www /var/www
COPY --from=node-build /var/www/frontend/web/js/dist /var/www/frontend/web/js/dist
COPY --from=node-build /var/www/frontend/web/css /var/www/frontend/web/css

RUN chown -R phpuser:phpuser /var/www

# Switch to non-root user before starting the php-fpm process
USER phpuser

ENTRYPOINT ["php-fpm"]