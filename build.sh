#!/bin/bash
# Vercel build script

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Build completed successfully!"
