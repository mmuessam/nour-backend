FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    git curl zip unzip libpq-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring xml bcmath ctype tokenizer opcache \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 8080

CMD sh -c "php artisan config:clear && php artisan migrate --force && php artisan db:seed --force --class=DatabaseSeeder 2>/dev/null; php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"
