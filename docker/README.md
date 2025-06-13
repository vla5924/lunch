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
docker/compose.sh exec -u www-data php cp .env.production .env
docker/compose.sh exec -u www-data php php artisan key:generate
docker/compose.sh exec -u www-data php php artisan migrate
docker/compose.sh exec -u www-data php php artisan db:seed
```

Check application logs:

```bash
docker/compose.sh logs php
docker/compose.sh logs nginx
docker/compose.sh exec php cat storage/logs/laravel.log
```
