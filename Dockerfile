FROM php:8.1-fpm

# Install required PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

CMD ["php-fpm"]
