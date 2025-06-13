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
```
