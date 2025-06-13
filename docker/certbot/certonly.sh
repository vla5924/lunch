#!/bin/bash

set -e

EMAIL=$1
DOMAIN=$2

THIS_DIR=$(realpath $(dirname $0))
COMPOSE_YAML=$THIS_DIR/../compose.yaml

docker compose -f $COMPOSE_YAML run --rm --entrypoint "\
  certbot certonly --webroot -w /var/www/certbot \
    --email $EMAIL \
    -d $DOMAIN \
    --rsa-key-size 4096 \
    --agree-tos \
    --no-eff-email \
    --keep-until-expiring" certbot

docker compose -f $COMPOSE_YAML exec nginx nginx -s reload
