#!/usr/bin/env bash
set -e

APP_DIR="${APP_DIR:-/var/www/dev/cooky-api}"

cd "$APP_DIR"

if [ ! -d vendor ] || [ ! -f vendor/autoload.php ]; then
  echo "Installing Composer dependencies..."
  composer install --no-interaction --prefer-dist
else
  echo "Composer dependencies already installed."
fi

mkdir -p var/cache var/log

if [ "${RUN_MIGRATIONS:-1}" = "1" ]; then
  echo "Running Doctrine migrations..."
  php bin/console doctrine:migrations:migrate --no-interaction || true
fi

if [ "${CLEAR_CACHE_ON_START:-0}" = "1" ]; then
  echo "Clearing Symfony cache..."
  php bin/console cache:clear || true
fi

echo "Starting PHP-FPM..."

exec "$@"
