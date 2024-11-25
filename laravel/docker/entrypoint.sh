#!/bin/bash

set -e

php artisan optimize:clear

# Start PHP-FPM and Nginx
php-fpm -D
nginx -g "daemon off;"
