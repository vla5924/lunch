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

Use Supervisor for the queue worker:

```bash
sudo apt-get install supervisor
sudo nano /etc/supervisor/conf.d/docker-lunch-laravel-worker.conf
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start "docker-lunch-laravel-worker:*"
```

Configuration file for Supervisor:

```
[program:docker-lunch-laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/docker compose -f /<path>/lunch/docker/compose.yaml exec php php artisan queue:work --quiet --sleep=10 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=<user>
numprocs=1
redirect_stderr=true
stdout_logfile=/home/<user>/docker-lunch-laravel-worker.log
stopwaitsecs=3600
```
