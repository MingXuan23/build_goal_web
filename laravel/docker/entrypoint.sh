#!/bin/bash

# Install Composer dependencies if vendor directory does not exist
if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-progress --no-interaction
    composer dump-autoload
fi

# Create .env if not exists
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# Apply permissions to storage/logs
if [ ! -w "/var/www/storage/logs" ]; then
    echo "Setting permissions for storage/logs..."
    chmod -R 775 /var/www/storage/logs
    chown -R www-data:www-data /var/www/storage/logs
fi

# Run Laravel optimizations
php artisan optimize
php artisan view:cache
php artisan optimize:clear

# Start PHP-FPM and Nginx
php-fpm -D
nginx -g "daemon off;"
