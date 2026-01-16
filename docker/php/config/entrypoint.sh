#!/bin/sh
sleep 1

curl -X PUT \
  --data-binary @/docker-entrypoint.d/config.json \
  --unix-socket /var/run/control.unit.sock \
  http://localhost/config

exec unitd --no-daemon
