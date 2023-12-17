FROM php:8.2.0-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and build tools
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libonig-dev \
    autoconf \
    gcc \
    make

# Install additional PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml curl

# Install and enable Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar a extensão zip
RUN apt-get update \
    && apt-get install -y zlib1g-dev libzip-dev \
    && docker-php-ext-install zip

# Install cURL with the version required by PHP extension
RUN apt-get install -y libcurl4 libcurl4-openssl-dev \
    && docker-php-ext-configure curl --with-curl \
    && docker-php-ext-install curl

# Install and enable redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install and enable xdebug extension
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install and enable pcov extension
RUN pecl install pcov && docker-php-ext-enable pcov


# Copy code base
COPY . .

# Install project dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction

# Create storage directory for Pail
RUN mkdir -p /var/www/storage/pail

# Adjust permissions for storage directory
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 775 /var/www/storage

# Adjust permissions for the Pail directory and its files
RUN chown -R www-data:www-data /var/www/storage/pail
RUN chmod -R 775 /var/www/storage/pail

# Defina UID e GID do usuário www-data para corresponder ao host
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Switch to www-data user for the following commands
USER www-data

# Start PHP-FPM
CMD ["php-fpm"]
