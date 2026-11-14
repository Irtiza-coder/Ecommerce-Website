#!/bin/sh
set -e

echo "==> Running Laravel deployment tasks..."

php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache || true
php /var/www/html/artisan view:cache || true

echo "==> Running database migrations..."
php /var/www/html/artisan migrate --force

if [ "${CREST_RESTORE_CATALOG:-false}" = "true" ]; then
    : "${CREST_ADMIN_PASSWORD:?Set CREST_ADMIN_PASSWORD before restoring the catalog}"
    echo "==> Restoring the saved catalog..."
    php /var/www/html/artisan db:seed --force
fi

echo "==> Linking storage..."
php /var/www/html/artisan storage:link || true

echo "==> Fixing storage permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

echo "==> Deployment tasks complete!"
