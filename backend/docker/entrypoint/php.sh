#!/bin/sh

# Génération des clés pour l'authentification JWT
if [ ! -d "/srv/php/config/jwt" ]; then
    echo "Create directory for JWT"
    mkdir -p /srv/php/config/jwt
fi

if [ ! -f "/srv/php/config/jwt/private.pem" ]; then
    echo "Create keys for JWT authentication"
    openssl genpkey -out /srv/php/config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:jwtsecret
    openssl pkey -in /srv/php/config/jwt/private.pem -out /srv/php/config/jwt/public.pem -pubout -passin pass:jwtsecret
    chmod +r /srv/php/config/jwt/private.pem
fi

if [ ! -f "/srv/php/.env.local" ]; then
    echo "Create .env.local to activate dev mode"
    printf "###> symfony/framework-bundle ###\nAPP_ENV=dev\n###< symfony/framework-bundle ###" > /srv/php/.env.local
fi

# On installe les dépendances pour pouvoir vérifier sur la BDD est démarée
composer install

./docker/entrypoint/wait_db.sh

# Lancement du serveur
./bin/console doctrine:database:drop --if-exists --force
./bin/console doctrine:database:create
./bin/console doctrine:schema:update --force --no-interaction --complete
./bin/console doctrine:fixtures:load -n

exec php-fpm -F
