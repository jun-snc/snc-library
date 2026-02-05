FROM php:8.2-apache

# タイムゾーン設定
ENV TZ=Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# システムパッケージの更新とインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    libmagickwand-dev \
    imagemagick \
    zip \
    unzip \
    git \
    curl \
    vim \
    && rm -rf /var/lib/apt/lists/*

# PHP拡張のインストール
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip exif

# Imagick拡張のインストール
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apacheのmod_rewrite有効化
RUN a2enmod rewrite

# DocumentRoot設定（Laravel未セットアップ時は/var/www/htmlを使用）
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html!g' /etc/apache2/sites-available/*.conf

# .htaccessを有効にする設定
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>' >> /etc/apache2/apache2.conf

# PHP設定の調整
RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "date.timezone = Asia/Tokyo" >> /usr/local/etc/php/conf.d/uploads.ini

# 作業ディレクトリ設定
WORKDIR /var/www/html

# ファイルパーミッション設定（起動時に実行されるスクリプトを配置）
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# エントリーポイント設定
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Apache起動
CMD ["apache2-foreground"]
