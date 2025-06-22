#!/bin/bash
set -e

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

composer install --no-interaction --optimize-autoloader
php artisan migrate
php artisan key:generate

apache2-foreground

exec "$@"
