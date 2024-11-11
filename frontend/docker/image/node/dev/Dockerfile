FROM node:22-alpine

RUN mkdir -p /app
WORKDIR /app

RUN npm install npm@10.8.2 -g
RUN npm i -g @angular/cli \
    && chmod -R 777 /root/

EXPOSE 4200 4200
