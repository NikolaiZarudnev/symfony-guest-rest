#!/bin/sh
set -e

rm -rf var/cache/*

composer update --no-plugins --no-scripts
composer install --prefer-dist --no-progress --no-interaction

echo "Waiting for db to be ready..."
ATTEMPTS_LEFT_TO_REACH_DATABASE=60
until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(bin/console dbal:run-sql "SELECT 1" 2>&1); do
    sleep 1
    ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
    echo "Still waiting for db to be ready... Or maybe the db is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left"
done

if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
    echo "The database is not up or not reachable:"
    echo "$DATABASE_ERROR"
    exit 1
else
    echo "The db is now ready and reachable"
fi

if ls -A migrations/*.php >/dev/null 2>&1; then
    bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing
fi

setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var

echo "running fpm"
exec docker-php-entrypoint "$@"