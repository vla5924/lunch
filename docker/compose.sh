#!/bin/bash

THIS_DIR=$(realpath $(dirname $0))

docker compose --project-directory $THIS_DIR --file $THIS_DIR/compose.yaml $@
