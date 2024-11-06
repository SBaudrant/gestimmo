FROM node:22-alpine

RUN mkdir -p /a5cache
WORKDIR /a5cache

COPY package.json .
COPY package-lock.json .
COPY angular.json .

RUN apk add grep git \
    && npm i

WORKDIR ${MOUNT_DIR}
