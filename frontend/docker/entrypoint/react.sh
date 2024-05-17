#!/bin/sh
NG_CLI_ANALYTICS=off npm install

tail -f /dev/null
exec npm start -- --progress=false
