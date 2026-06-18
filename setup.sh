#!/bin/bash

echo "======================================"
echo "  Taskify - Setup Script"
echo "======================================"

# Check PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP not found. Install PHP 8.1+ first."
    echo "   macOS: brew install php"
    echo "   Ubuntu: sudo apt install php8.2 php8.2-sqlite3 php8.2-mbstring"
    exit 1
fi

echo "✅ PHP $(php -r 'echo PHP_VERSION;') found"

# Check Composer
if ! command -v composer &> /dev/null; then
    echo "⬇  Installing Composer..."
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
fi

echo "✅ Composer found"

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-interaction --optimize-autoloader

# Environment setup
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Created .env file"
fi

# Generate app key
php artisan key:generate
echo "✅ App key generated"

# Create SQLite database
touch database/database.sqlite
echo "✅ SQLite database created"

# Run migrations
php artisan migrate --force
echo "✅ Database migrations run"

# Seed demo data
php artisan db:seed --force
echo "✅ Demo data seeded (12 sample tasks)"

# Create storage symlink
php artisan storage:link 2>/dev/null || true

echo ""
echo "======================================"
echo "  ✅ Taskify is ready!"
echo "======================================"
echo ""
echo "  Run: php artisan serve"
echo "  Open: http://localhost:8000"
echo ""
