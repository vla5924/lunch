FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y curl git libcurl4-openssl-dev libsqlite3-dev libxml2-dev nano unzip zip \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/database \
    && chmod -R 755 /var/www/html/storage

EXPOSE 9000

CMD ["php-fpm"]
