# Docker環境 クイックスタートガイド

本プロジェクトをDocker環境で素早く起動するためのガイドです。
詳細な手順は `document/06_環境構築手順書.md` を参照してください。

## 🚀 クイックスタート

### 1. Docker環境の起動

```bash
cd /Users/jun/Documents/_app/library_app_docker

# コンテナをビルド・起動
docker-compose up -d --build

# ログを確認
docker-compose logs -f app
```

### 2. Laravelプロジェクトのセットアップ

```bash
# コンテナ内に入る
docker-compose exec app bash

# Laravelプロジェクトを作成
composer create-project laravel/laravel . "10.*"

# Intervention Imageをインストール
composer require intervention/image

# APP_KEYの生成
php artisan key:generate

# .envのDB設定を編集（DB_HOST=db に変更）
vi .env

# ストレージディレクトリ作成
mkdir -p storage/app/public/uploads/{original,display,thumb}
chmod -R 775 storage bootstrap/cache

# ストレージリンクの作成
php artisan storage:link

# マイグレーション実行
php artisan migrate

# コンテナから退出
exit
```

### 3. アクセス

- **アプリケーション**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081 (user: library_user / pass: library_pass)

## 📦 Docker構成

| サービス | ポート | 説明 |
|---------|--------|------|
| app | 8080 | Apache + PHP 8.2 |
| db | 3307 | MySQL 8.0 |
| phpmyadmin | 8081 | phpMyAdmin |

## 🛠 よく使うコマンド

```bash
# コンテナ起動/停止
docker-compose up -d
docker-compose down

# コンテナ内でコマンド実行
docker-compose exec app bash
docker-compose exec app php artisan migrate
docker-compose exec app composer install

# ログ確認
docker-compose logs -f app

# データベース接続
docker-compose exec db mysql -u library_user -plibrary_pass library_db
```

## 🔧 トラブルシューティング

### パーミッションエラー

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### データベース接続エラー

.envファイルで以下を確認：
```env
DB_HOST=db
DB_DATABASE=library_db
DB_USERNAME=library_user
DB_PASSWORD=library_pass
```

### 完全リセット

```bash
docker-compose down -v
docker-compose up -d --build
```
