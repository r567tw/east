# 使用 PHP 官方映像
FROM php:8.3-fpm

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libxml2-dev

# 設置 gd 擴展的配置以支持 jpeg 和 freetype
RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/

# 安裝 PHP 擴展
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 安裝 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www

# 設置權限
RUN chown -R www-data:www-data /var/www

# 判斷有沒有 artisn 檔案

# 暴露端口
EXPOSE 9000

CMD ["php-fpm"]
