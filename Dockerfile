FROM php:8.2-cli-bookworm

# System dependencies + Tesseract OCR + Node.js
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    tesseract-ocr \
    tesseract-ocr-eng \
    tesseract-ocr-ind \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    xml

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Build frontend assets if package.json exists
RUN if [ -f package.json ]; then \
        npm install && npm run build; \
    fi

# Laravel writable directories
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create public storage link
RUN php artisan storage:link || true

# Clear Laravel caches
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# Tesseract configuration for Linux
ENV TESSERACT_PATH=/usr/bin/tesseract
ENV TESSDATA_PATH=/usr/share/tesseract-ocr/5/tessdata

# Render provides PORT automatically
EXPOSE 10000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
