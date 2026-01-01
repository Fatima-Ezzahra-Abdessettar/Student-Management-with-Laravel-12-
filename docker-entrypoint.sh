#!/bin/bash
set -e

echo "Starting PHP container..."

# Wait for MySQL
until php -r "
try {
    new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=3306',
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

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Run seeders (optional)
# php artisan db:seed --force

# Create storage symlink
php artisan storage:link || true

# Start PHP-FPM
exec php-fpm -F