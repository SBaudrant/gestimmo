USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
# Import all variables from .env file
include ../.env
export

.DEFAULT_GOAL := help
help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m\033[0m\n"} /^[0-9a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-30s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

docker-compose-user-exec = docker compose exec -T --user ${USER_ID}:${GROUP_ID} ${1}
docker-compose-root-exec = docker compose exec -T ${1}

# ------------------------
# Lancement des containers
# ------------------------

up: ##Lancement de l'environnement de dev pour le backend
	docker compose up

down: ##Arrêt de l'environnement de dev pour le backend
	docker compose down

up-tests: ##Exécution des tests du backend
	docker compose run --rm php ./vendor/bin/phpunit

# ------
# Récupération des images depuis le registry GitLab
# ------

pull: pull-base pull-dev pull-test ##Mise à jour des images Docker pour le backend

pull-base: ##Mise à jour de l'image Docker de base pour le backend
	docker pull $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/base:latest

pull-dev: ##Mise à jour de l'image Docker de dev pour le backend
	docker pull $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/dev:latest

pull-test: ##Mise à jour de l'image Docker de test pour le backend
	docker pull $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/test:latest

# ------
# Envoi des images dans le registry GitLab
# ------

push: push-base push-dev push-test ##Envoi des 3 images backend base/dev/test au registry

push-base: ##Envoi de l'image Docker de base pour le backend au registry
	docker push $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/base:latest

push-dev: ##Envoi de l'image Docker de dev pour le backend au registry
	docker push $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/dev:latest

push-test: ##Envoi de l'image Docker de test pour le backend au registry
	docker push $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/test:latest

# ------
# Construction des images
# ------

build: build-base build-dev build-test ##Reconstruction des 3 images backend base/dev/test

build-and-push: build push ##Reconstruction des 3 images backend base/dev/test et envoi au registry

build-base: ##Reconstruction de l'image Docker de base pour le backend
	docker build --pull -t $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/base:latest -f ./docker/image/php/base/Dockerfile ./docker/image/php/base

build-base-and-push: build-base push-base ##Reconstruction de l'image Docker de base pour le backend et envoi au registry

build-dev: ##Reconstruction de l'image Docker de dev pour le backend
	docker build -t $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/dev:latest -f ./docker/image/php/dev/Dockerfile ./docker/image/php/dev

build-dev-and-push: build-dev push-dev ##Reconstruction de l'image Docker de dev pour le backend et envoi au registry

build-test: ##Reconstruction de l'image Docker de test pour le backend
	docker build -t $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(BACKEND_FOLDER)/test:latest -f ./docker/image/php/test/Dockerfile .

build-test-and-push: build-test push-test ##Reconstruction de l'image Docker de test pour le backend et envoi au registry

# ------
# Création des livrables
# ------

build-prod: ##Génération du zip de prod du backend
	docker compose pull php
	docker compose run -T -e APP_ENV=prod --rm --no-deps --entrypoint="" php composer install --no-interaction --no-progress --no-dev --optimize-autoloader --no-scripts
	docker compose run -T -e APP_ENV=prod --rm --no-deps --entrypoint="" php composer run post-autoload-dump
	docker compose run -T -e APP_ENV=prod --rm --no-deps --entrypoint="" php ./bin/console assets:install public
	docker run --rm -v $(shell pwd):/root $(GITLAB_REGISTRY)/docker/tools/ant:latest ant

# ------
# Outils
# ------

exec-cmd: ##Lancement d'une commande sur le backend (make run-cmd CMD="ls .")
	$(call docker-compose-user-exec, php $(CMD))

exec-root-cmd: ##Lancement d'une commande sur le backend (make run-cmd CMD="ls .")
	$(call docker-compose-root-exec, php $(CMD))

exec-root-bash: ##Ouvre un terminal bash sur le backend (pour composer, psalm, phpstan, phpcs)
	docker compose exec php sh

bash: ##Ouvre un terminal bash sur le backend
	docker compose exec --user ${USER_ID}:${GROUP_ID} php sh

migration: ##Création des migrations Doctrine
	$(call docker-compose-user-exec, php php bin/console doctrine:migrations:diff --no-interaction)

migrate: ##Création des migrations Doctrine
	$(call docker-compose-user-exec, php php bin/console doctrine:migrations:migrate --no-interaction)

fixture: ##Chargement des fixtures
	$(call docker-compose-user-exec, php bin/console doctrine:database:drop --if-exists --force)
	$(call docker-compose-user-exec, php bin/console doctrine:database:create)
	$(call docker-compose-user-exec, php bin/console doctrine:schema:create)
	$(call docker-compose-user-exec, php bin/console doctrine:fixtures:load -n)

alicefixture: ##Chargement des fixtures
	$(call docker-compose-user-exec, php bin/console doctrine:database:drop --if-exists --force)
	$(call docker-compose-user-exec, php bin/console doctrine:database:create)
	$(call docker-compose-user-exec, php bin/console doctrine:schema:create)
	$(call docker-compose-user-exec, php bin/console hautelook:fixtures:load -n)

entities: ##Génère les getter/setter appropriés pour les entités
	$(call docker-compose-user-exec, php bin/console make:entity --regenerate)

dsu: ##Mise à jour du schéma de BDD
	$(call docker-compose-user-exec, php bin/console doctrine:schema:update --force)

i18n: ##Dump les nouvelles traductions
	$(call docker-compose-user-exec, php bin/console translation:extract --dump-messages --sort=desc fr --force)

SERVER_LOG_PARAMS=--filter="level > 200 or channel in ['app']" --date-format="H:i:s.u"
log-server: ##Lance un serveur CLI affichant le contenu des logs
	$(call docker-compose-user-exec, php bin/console server:log $(SERVER_LOG_PARAMS))

dump-server: ##Lance un serveur CLI affichant le contenu des dump()
	$(call docker-compose-user-exec, php bin/console server:dump)

fix: ##Auto corrige phpcs
	-$(call docker-compose-user-exec, php ./vendor/bin/phpcbf)

phpcs: ##phpcs
	-$(call docker-compose-user-exec, php ./vendor/bin/phpcs)
