#!/bin/bash

# Set permissions for the entire /var/www directory and its contents
chown -R www-data:www-data /var/www
chmod -R 777 /var/www

# Start PHP-FPM
php-fpm
