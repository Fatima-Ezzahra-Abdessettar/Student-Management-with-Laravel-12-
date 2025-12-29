#!/bin/bash
set -e

echo "Starting PHP container..."

# Wait for MySQL (REAL check)
until php -r "
try {
    new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );
} catch (Exception \$e) {
    exit(1);
}
"; do
  echo "Waiting for MySQL..."
  sleep 2
done

# Run migrations only in dev
if [ "$APP_ENV" != "production" ]; then
    php artisan migrate --force || true
fi

# Create storage symlink
php artisan storage:link || true

# Start PHP-FPM (MUST be last)
exec php-fpm -F
