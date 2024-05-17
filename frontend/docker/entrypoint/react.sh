#!/bin/sh
NG_CLI_ANALYTICS=off yarn install
exec yarn start -- --progress=false
