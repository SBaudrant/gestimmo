FROM node:22-alpine

RUN mkdir -p /app
WORKDIR /app

RUN npm install npm@latest -g
RUN npm i -g @angular/cli \
    && chmod -R 777 /root/

EXPOSE 4200 4200
