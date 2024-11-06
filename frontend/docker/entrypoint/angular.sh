#!/bin/sh

if [ ! -f "/app/src/assets/parameters.json" ]; then
    cp /app/src/assets/parameters.json.dist /app/src/assets/parameters.json
fi

NG_CLI_ANALYTICS=off npm install
exec npm start
