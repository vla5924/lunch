FROM php:8.4-fpm

RUN apt-get update \
    && apt-get install -y curl git libcurl4-openssl-dev libsqlite3-dev libxml2-dev nano unzip zip \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG APP_DIR="/var/www/html"
ARG DATABASE_DIR="/var/www/database"
ARG WWW_USER="www-data:www-data"

RUN mkdir -p ${APP_DIR} \
    && chown -R ${WWW_USER} ${APP_DIR} \
    && mkdir -p ${DATABASE_DIR} \
    && chown -R ${WWW_USER} ${DATABASE_DIR} \
    && chmod -R 755 ${DATABASE_DIR}

USER ${WWW_USER}

WORKDIR ${APP_DIR}

COPY --chown=${WWW_USER} composer.json composer.lock ./

RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist

COPY --chown=${WWW_USER} . .

RUN composer dump-autoload \
    && composer run-script post-autoload-dump \
    && chmod -R 755 ${APP_DIR}/storage

EXPOSE 9000

CMD ["php-fpm"]
