#!/bin/bash
# Install Composer dependencies if vendor directory does not exist
if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-progress --no-interaction
    composer dump-autoload
fi
set -e

php artisan optimize:clear

# Start PHP-FPM and Nginx
php-fpm -D
nginx -g "daemon off;"
