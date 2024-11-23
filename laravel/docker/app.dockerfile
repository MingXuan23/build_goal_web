# Used for prod build.
FROM php:8.1-fpm as php

# Install dependencies.
RUN apt-get update && apt-get install -y unzip libpq-dev libcurl4-gnutls-dev nginx libonig-dev

# Install PHP extensions.
RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath curl opcache mbstring

# Copy composer executable.
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# Copy configuration files.
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Set working directory to /var/www.
WORKDIR /var/www

# Copy files from current folder to container current folder (set in workdir).
COPY --chown=www-data:www-data . .

# Create laravel caching folders.
# Create laravel caching folders
RUN mkdir -p /var/www/storage/framework/{sessions,cache,testing,views} && \
    chown -R www-data:www-data /var/www/storage && \
    chmod -R 775 /var/www/storage && \
    chmod -R 775 /var/www/storage/framework && \
    chmod -R 775 /var/www/storage/framework/sessions && \
    chmod -R 775 /var/www/bootstrap/cache


# Run the entrypoint file.
ENTRYPOINT ["sh","docker/entrypoint.sh" ]


# FROM php:8.2-fpm-alpine as php

# RUN apk add --no-cache unzip libpq-dev gnutls-dev autoconf build-base \
#     curl-dev nginx supervisor shadow bash
# RUN docker-php-ext-install pdo pdo_mysql
# RUN pecl install pcov && docker-php-ext-enable pcov

# WORKDIR /app

# # Setup PHP-FPM.
# COPY docker/php/php.ini $PHP_INI_DIR/
# COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
# COPY docker/php/conf.d/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

# RUN addgroup --system --gid 1000 customgroup
# RUN adduser --system --ingroup customgroup --uid 1000 customuser

# # Setup nginx.
# COPY docker/nginx/nginx.conf docker/nginx/fastcgi_params docker/nginx/fastcgi_fpm docker/nginx/gzip_params /etc/nginx/
# RUN mkdir -p /var/lib/nginx/tmp /var/log/nginx
# RUN /usr/sbin/nginx -t -c /etc/nginx/nginx.conf

# # setup nginx user permissions
# RUN chown -R customuser:customgroup /var/lib/nginx /var/log/nginx
# RUN chown -R customuser:customgroup /usr/local/etc/php-fpm.d

# # Setup supervisor.
# COPY docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

# # Copy application sources into the container.
# COPY --chown=customuser:customgroup . .
# RUN chown -R customuser:customgroup /app
# RUN chmod +w /app/public
# RUN chown -R customuser:customgroup /var /run

# # disable root user
# RUN passwd -l root
# RUN usermod -s /usr/sbin/nologin root

# USER customuser
# COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# ENTRYPOINT ["docker/entrypoint.sh"]

# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]