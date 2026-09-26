#!/bin/sh
set -e

echo "==> Running Laravel deployment tasks..."

php /var/www/html/artisan config:cache || true
php /var/www/html/artisan route:cache || true
php /var/www/html/artisan view:cache || true

echo "==> Running database migrations..."
php /var/www/html/artisan migrate --force || true

echo "==> Seeding database..."
php /var/www/html/artisan db:seed --force || true

echo "==> Fixing storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

echo "==> Deployment tasks complete!"
