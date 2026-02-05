# SNCライブラリ - グラフィックデザイン管理システム

Laravel 10.x + Docker で構築する画像管理Webアプリケーションです。
グラフィックデザインをジャンル・タグで整理し、ライトボックス形式で閲覧できます。

## 📋 プロジェクト概要

- **フレームワーク**: Laravel 10.x
- **言語**: PHP 8.2
- **データベース**: MySQL 8.0
- **Webサーバー**: Apache 2.4
- **画像処理**: Intervention Image (Imagick/GD)
- **開発環境**: Docker Compose

## 🚀 クイックスタート

### 1. リポジトリのクローン

```bash
cd /Users/jun/Documents/_app
git clone <repository-url> library_app_docker
cd library_app_docker
```

### 2. Docker環境の起動

```bash
# Docker Composeでコンテナをビルド・起動
docker-compose up -d --build

# ログを確認
docker-compose logs -f app
```

### 3. Laravelプロジェクトのセットアップ

#### 方法A: コンテナ内で新規Laravel作成

```bash
# コンテナ内に入る
docker-compose exec app bash

# Laravelプロジェクトを作成（srcディレクトリに）
cd /var/www/html
composer create-project laravel/laravel . "10.*"

# Intervention Imageをインストール
composer require intervention/image

# APP_KEYの生成
php artisan key:generate

# .envファイルを設定（DB接続情報など）
cp /var/www/html/.env.example /var/www/html/.env
# .envのDB設定を以下に変更:
# DB_HOST=db
# DB_DATABASE=library_db
# DB_USERNAME=library_user
# DB_PASSWORD=library_pass

# ストレージディレクトリ作成
mkdir -p storage/app/public/uploads/{original,display,thumb}

# ストレージリンクの作成
php artisan storage:link

# マイグレーション実行
php artisan migrate

# コンテナから退出
exit
```

#### 方法B: 既存プロジェクトを配置

```bash
# 既存のLaravelプロジェクトをsrcディレクトリにコピー
cp -r /path/to/existing/laravel/* ./src/

# コンテナ内で依存関係をインストール
docker-compose exec app composer install

# .envファイルを設定
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate

# マイグレーション実行
docker-compose exec app php artisan migrate
```

### 4. アクセス確認

- **アプリケーション**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
  - ユーザー名: `library_user`
  - パスワード: `library_pass`

## 📁 プロジェクト構成

```
library_app_docker/
├── docker/                      # Docker設定
│   ├── php/
│   │   ├── Dockerfile          # PHP + Apache設定
│   │   └── entrypoint.sh       # 起動時スクリプト
│   └── mysql/
│       └── init/
│           └── 01_init.sql     # DB初期化スクリプト
├── src/                         # Laravelプロジェクト（ここに配置）
│   ├── app/
│   ├── public/
│   ├── resources/
│   └── ...
├── document/                    # プロジェクトドキュメント
│   ├── 01_要件定義.md
│   ├── 02_仕様書.md
│   ├── 03_設計書.md
│   ├── 04_DB初期化.sql
│   ├── 05_デプロイ運用.md
│   └── 06_環境構築手順書.md
├── docker-compose.yml           # Docker Compose設定
├── .env.example                 # 環境変数サンプル
└── README.md                    # このファイル
```

## 🐳 Docker環境の構成

| サービス | ポート | 説明 |
|---------|--------|------|
| app | 8080 | Apache + PHP 8.2（Laravel） |
| db | 3307 | MySQL 8.0 |
| phpmyadmin | 8081 | phpMyAdmin |

### 環境変数

`.env` ファイル（`.env.example` からコピー）で以下を設定：

```env
# データベース接続（Docker環境）
DB_HOST=db
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=library_user
DB_PASSWORD=library_pass

# 管理者パスワード（ハッシュ化）
ADMIN_PASSWORD_HASH='$2y$10$...'

# 画像処理設定
MAX_DISPLAY_WIDTH=4096
THUMB_MAX_SIZE=512
```

## 🛠 よく使うコマンド

### Docker操作

```bash
# コンテナ起動
docker-compose up -d

# コンテナ停止
docker-compose down

# コンテナ再起動
docker-compose restart

# ログ確認
docker-compose logs -f app

# コンテナ内でコマンド実行
docker-compose exec app bash

# データベース含めて完全削除
docker-compose down -v
```

### Laravel操作（コンテナ内）

```bash
# マイグレーション
docker-compose exec app php artisan migrate

# キャッシュクリア
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# ストレージリンク作成
docker-compose exec app php artisan storage:link

# Tinker（対話型シェル）
docker-compose exec app php artisan tinker

# Composer
docker-compose exec app composer install
docker-compose exec app composer update
```

### データベース操作

```bash
# MySQLに接続
docker-compose exec db mysql -u library_user -p library_db
# パスワード: library_pass

# SQLファイルをインポート
docker-compose exec -T db mysql -u library_user -p library_db < ./document/04_DB初期化.sql

# バックアップ
docker-compose exec db mysqldump -u library_user -p library_db > backup.sql
```

## 📦 必要なPHP拡張

以下の拡張がDockerイメージに含まれています：

- `pdo_mysql` - データベース接続
- `gd` - 画像処理（基本）
- `imagick` - 画像処理（高度、WebP対応）
- `zip` - ファイル圧縮
- `exif` - 画像メタデータ

## 🔧 トラブルシューティング

### コンテナが起動しない

```bash
# ログを確認
docker-compose logs

# 完全にクリーンアップして再ビルド
docker-compose down -v
docker-compose up -d --build
```

### データベース接続エラー

```bash
# .envのDB_HOSTが "db" になっているか確認
# コンテナ間通信の確認
docker-compose exec app ping -c 3 db
```

### パーミッションエラー

```bash
# ストレージディレクトリの権限設定
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### 画像アップロードができない

```bash
# ディレクトリ作成
docker-compose exec app mkdir -p storage/app/public/uploads/{original,display,thumb}

# 権限設定
docker-compose exec app chmod -R 775 storage/app/public

# ストレージリンク再作成
docker-compose exec app php artisan storage:link
```

## 📚 ドキュメント

詳細な仕様や設計については、`document/` ディレクトリ内のドキュメントを参照してください：

- [要件定義書](document/01_要件定義.md)
- [仕様書](document/02_仕様書.md)
- [設計書](document/03_設計書.md)
- [環境構築手順書](document/06_環境構築手順書.md)

## 🚢 本番環境へのデプロイ

Xserverへのデプロイ手順は [05_デプロイ運用.md](document/05_デプロイ運用.md) を参照してください。

## 📝 ライセンス

このプロジェクトはプライベート利用です。

## 👤 作成者

SNC - 2026
