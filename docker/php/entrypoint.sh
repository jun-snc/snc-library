#!/bin/bash

# Laravelプロジェクトが存在する場合のみ権限設定
if [ -d "/var/www/html/storage" ]; then
    echo "Setting permissions for Laravel directories..."
    chown -R www-data:www-data /var/www/html/storage
    chown -R www-data:www-data /var/www/html/bootstrap/cache
    chmod -R 775 /var/www/html/storage
    chmod -R 775 /var/www/html/bootstrap/cache
    
    # ストレージディレクトリ作成
    mkdir -p /var/www/html/storage/app/public/uploads/{original,display,thumb}
    chown -R www-data:www-data /var/www/html/storage/app/public
    chmod -R 775 /var/www/html/storage/app/public
fi

# Composerの依存関係インストール（composer.jsonが存在する場合）
if [ -f "/var/www/html/composer.json" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

# Laravelのキャッシュクリア（.envが存在する場合）
if [ -f "/var/www/html/.env" ]; then
    echo "Clearing Laravel caches..."
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    
    # ストレージリンクの作成
    if [ ! -L "/var/www/html/public/storage" ]; then
        php artisan storage:link
    fi
fi

# Apacheを起動
exec "$@"
