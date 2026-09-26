FROM serversideup/php:8.4-fpm-nginx

USER root

# Copy application files with proper www-data ownership
COPY --chown=www-data:www-data . /var/www/html

# Copy startup deployment script into entrypoint directory
COPY --chmod=755 scripts/00-laravel-deploy.sh /etc/entrypoint.d/00-laravel-deploy.sh

# Install Composer dependencies at build time using PHP 8.4
USER www-data
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8080
