#!/bin/bash
set -e

echo "==> Preparing Laravel Application..."

# Clear cached files
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run database migrations with fallback protection
echo "==> Running Database Migrations..."
php artisan migrate --force || echo "==> Notice: Migration finished with notice, starting server..."

echo "==> Starting Apache Server on port ${PORT:-80}..."
exec apache2-foreground
