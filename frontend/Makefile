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

up: ##Lancement de l'environnement de dev pour le fronted
	docker compose up

down: ##Arrêt de l'environnement de dev pour le frontend
	docker compose down

# ------
# Envoi des images dans le registry GitLab
# ------

push: push-dev push-lint ##Envoi des images dev/lint au registry

push-dev: ##Envoi de l'image Docker de dev pour le front au registry
	docker push $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/dev:latest

push-lint: ##Envoi de l'image Docker de dev pour le front au registry
	docker push $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/lint:latest
# ------
# Construction des images
# ------

build: build-dev build-lint ##Reconstruction de l'image frontend dev

build-and-push: build push ##Reconstruction des 2 images frontend dev/test et envoi au registry

build-dev: ##Reconstruction de l'image Docker de dev pour le frontend
	docker build -t $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/dev -f ./docker/image/node/dev/Dockerfile ./docker/image/node/dev

build-dev-and-push: build-dev push-dev ##Reconstruction de l'image Docker de dev pour le frontend et envoi au registry

build-lint: ##Reconstruction de l'image Docker de lint pour le frontend
	docker build -t $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/lint -f ./docker/image/node/lint/Dockerfile .
build-lint-and-push: build-lint push-lint ##Reconstruction de l'image Docker de lint pour le frontend et envoi au registry

# ------
# Création des livrables
# ------

build-prod: ##Génération du zip de prod du frontend
	docker compose pull angular
	docker compose run -e NG_CLI_ANALYTICS=ci --rm --entrypoint="" angular npm ci
	docker compose run --rm --entrypoint="" angular npm run build-prod
	docker run --rm -v $(shell pwd):/root $(GITLAB_REGISTRY)/docker/tools/ant:latest ant

# ------
# Outils
# ------

exec-cmd: ##Lancement d'une commande sur le frontend (make run-cmd CMD="ls .")
	$(call docker-compose-user-exec, angular $(CMD))

exec-root-cmd: ##Lancement d'une commande sur le frontend (make run-cmd CMD="ls .")
	$(call docker-compose-root-exec, angular $(CMD))

exec-bash: ##Ouvre un terminal bash sur le frontend
	docker compose exec --user ${USER_ID}:${GROUP_ID} angular sh

exec-root-bash: ##Ouvre un terminal bash sur le frontend
	docker compose exec angular sh

i18n: ##Mise à jour des fichiers de traductions
	$(call docker-compose-user-exec, angular npm run i18n:extract)

doc: ##Génération de la doc du projet Angular sur http://localhost:4201
	$(call docker-compose-user-exec, angular npm run doc)

pull:
	docker pull $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/dev:latest
	docker pull $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/lint:latest

fix: ##Autocorrige eslint
	$(call docker-compose-user-exec, angular ng lint --fix)

eslint: ##eslint
	$(call docker-compose-user-exec, angular ng lint)
