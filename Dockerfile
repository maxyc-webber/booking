FROM php:8.1-fpm

# Установить необходимые пакеты и расширения
RUN apt-get update && \
    apt-get install -y git unzip libzip-dev && \
    docker-php-ext-install pdo_mysql zip

# Установить Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Копировать composer-файлы и установить зависимости
COPY composer.json composer.lock ./
# Копировать остальное приложение
COPY . .
RUN composer install --optimize-autoloader --no-scripts

CMD ["php-fpm"]
