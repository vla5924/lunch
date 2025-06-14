FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y curl git libcurl4-openssl-dev libsqlite3-dev libxml2-dev nano unzip zip \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG APP_DIR=/var/www/html

COPY composer.json composer.lock ${APP_DIR}

WORKDIR ${APP_DIR}

RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist

COPY . .

RUN composer dump-autoload \
    && composer run-script post-autoload-dump \
    && chown -R www-data:www-data ${APP_DIR} \
    && chmod -R 755 ${APP_DIR}/storage

ARG DATABASE_DIR=/var/www/database

RUN mkdir ${DATABASE_DIR} \
    && chown -R www-data:www-data ${DATABASE_DIR} \
    && chmod -R 755 ${DATABASE_DIR}

EXPOSE 9000

CMD ["php-fpm"]
