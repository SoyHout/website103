#!/bin/bash
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "Setting up Laravel application..."
    composer install --no-interaction --prefer-dist --no-progress --no-scripts
fi

if [ ! -f ".env" ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

php-fpm -D
nginx -g "daemon off;"