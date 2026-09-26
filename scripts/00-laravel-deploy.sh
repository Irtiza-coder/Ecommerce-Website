#!/usr/bin/env bash
echo "==> Running Composer Install..."
composer install --no-dev --working-dir=/var/www/html --optimize-autoloader --no-interaction

echo "==> Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running database migrations..."
php artisan migrate --force

echo "==> Seeding database..."
php artisan db:seed --force

echo "==> Deployment tasks completed successfully!"
