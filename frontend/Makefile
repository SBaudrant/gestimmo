USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)

# Import all variables from .env file
include ../.env
export

.DEFAULT_GOAL := help
help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m\033[0m\n"} /^[0-9a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-30s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

# ------------------------
# Lancement des containers
# ------------------------

up: ##Lancement de l'environnement de dev pour le frontend
	docker-compose up -d

down: ##Arrêt de l'environnement de dev pour le frontend
	docker-compose down

# ------
# Envoi des images dans le registry GitLab
# ------

push: push-dev ##Envoi de l'image dev au registry

push-dev: ##Envoi de l'image Docker de dev pour le front au registry
	docker push $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/dev:latest

# ------
# Construction des images
# ------

build: build-dev ##Reconstruction de l'image frontend dev

build-and-push: build push ##Reconstruction des 2 images frontend dev/test et envoi au registry

build-dev: ##Reconstruction de l'image Docker de dev pour le frontend
	docker-compose build

build-dev-and-push: build-dev push-dev ##Reconstruction de l'image Docker de dev pour le frontend et envoi au registry

# ------
# Création des livrables
# ------

build-prod: ##Génération du zip de prod du frontend
	docker-compose pull react
	docker-compose run -e NG_CLI_ANALYTICS=ci --rm --entrypoint="" react npm ci
	docker-compose run --rm --entrypoint="" react npm run build-prod
	docker run --rm -v $(shell pwd)/frontend:/root $(GITLAB_REGISTRY)/docker/tools/ant:latest ant

# ------
# Outils
# ------

exec-cmd: ##Lancement d'une commande sur le frontend (make run-cmd CMD="ls .")
	docker-compose exec react $(CMD)

exec-root-bash: ##Ouvre un terminal bash sur le frontend (pour composer, psalm, phpstan, phpcs)
	docker-compose exec react sh

bash: ##Ouvre un terminal bash sur le frontend
	docker compose exec --user ${USER_ID}:${GROUP_ID} react sh

i18n: ##i18n
	docker-compose exec react npm run extract

frontend-doc: ##Génération de la doc du projet Angular sur http://localhost:4201
	docker-compose exec react npm run doc

pull:
	docker pull $(GITLAB_REGISTRY)/$(CLIENT_TECHNICAL_NAME)/$(PROJECT_TECHNICAL_NAME)/$(FRONTEND_FOLDER)/dev:latest