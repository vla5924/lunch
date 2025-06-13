#!/bin/bash

set -e

export DOMAIN=$1
THIS_DIR=$(realpath $(dirname $0))

envsubst '${DOMAIN}' < $THIS_DIR/nginx.conf.template > $THIS_DIR/nginx.conf
