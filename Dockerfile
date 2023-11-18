FROM php:8.2.0-fpm

# Set working directory
WORKDIR /var/www

RUN apt-get update && apt-get upgrade -y

# Install system dependencies
RUN apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libxml2-dev \
    libpcre3-dev \
    libssl-dev \
    libnghttp2-dev

# Install and enable Swoole
RUN pecl install swoole && docker-php-ext-enable swoole

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml curl

# Create SQLite file and directory
RUN mkdir -p /var/www/database
RUN touch /var/www/database/database.sqlite
RUN chown -R www-data:www-data /var/www/database

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy code base
COPY . /var/www

# Install dependencies
RUN composer install --no-interaction

# Copy the initialization script
COPY init.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/init.sh

# Start PHP-FPM with the initialization script
CMD ["/usr/local/bin/init.sh"]
