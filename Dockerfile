FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y \
        curl \
        git \
        unzip \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libsqlite3-dev \
        default-mysql-client \
        zlib1g-dev \
        libsqlite3-dev \
    && curl -fsSL https://nodesource.com | bash - '
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html

COPY composer.json composer.lock* package.json package-lock.json* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && npm install

COPY . .
RUN cp .env.example .env \
    && php artisan key:generate --force \
    && npm run build \
    && php artisan config:cache \
    && php artisan view:cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
