# Deployment

Prepare NGINX configuration:

```bash
docker/nginx/subst.sh $DOMAIN
```

Run services:

```bash
docker/compose.sh up -d
```

Renew certificates:

```bash
docker/certbot/certonly.sh $EMAIL $DOMAIN
```

Reload NGINX if needed:

```bash
docker/compose.sh exec nginx nginx -s reload
```

Stop services:

```bash
docker/compose.sh down
docker/compose.sh down -v # also remove volumes
```

Initialize Laravel:

```bash
docker/compose.sh exec php cp .env.production .env
docker/compose.sh exec php php artisan key:generate
```

Recover from existing database:

```bash
docker/compose.sh cp database.sqlite php:/var/www/database
docker/compose.sh exec -u0 php chown -R www-data:www-data /var/www/database
```

Setup database:

```bash
docker/compose.sh exec php php artisan migrate
docker/compose.sh exec php php artisan db:seed # fresh installation
docker/compose.sh exec php php artisan db:seed AdminSeeder # optionally
```

Backup database to host:

```bash
docker/compose.sh cp php:/var/www/database/database.sqlite .
```

Check application logs:

```bash
docker/compose.sh logs php
docker/compose.sh logs nginx
docker/compose.sh exec php cat storage/logs/laravel.log
```
