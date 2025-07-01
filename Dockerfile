FROM php:8.0-fpm

# Install required PHP extensions
RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

COPY . .

CMD ["php-fpm"]
