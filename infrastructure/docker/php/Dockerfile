FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
 && docker-php-ext-install pdo pdo_mysql zip

# Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Optional: install Composer (if you want local dev inside container)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
