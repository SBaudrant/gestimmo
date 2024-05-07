# Import all variables from .env file
include .env
export

.DEFAULT_GOAL := help

.PHONY: frontend
.PHONY: backend
.PHONY: ansible

help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m\033[0m\n"} /^[0-9a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-30s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

# ------------------------
# Lancement des containers
# ------------------------

up: ##Lancement de l'application complète (backend et frontend)
	{ make -C $(BACKEND_FOLDER) up & (sleep 1 && make -C $(FRONTEND_FOLDER) up); } | cat

down: ##Coupe les containers
	make -C $(FRONTEND_FOLDER) down
	make -C $(BACKEND_FOLDER) down

backend: ##Lance les commandes du backend. Voir: make backend help
	$(MAKE) -C $(BACKEND_FOLDER) $(filter-out $@,$(MAKECMDGOALS))

frontend: ##Lance les commandes du frontend. Voir: make frontend help
	$(MAKE) -C $(FRONTEND_FOLDER) $(filter-out $@,$(MAKECMDGOALS))

ansible: ##Lance les commandes du ansible. Voir: make ansible help
	$(MAKE) -C $(ANSIBLE_FOLDER) $(filter-out $@,$(MAKECMDGOALS))

pull:
	make -C $(FRONTEND_FOLDER) pull
	make -C $(BACKEND_FOLDER) pull

build:
	make -C $(FRONTEND_FOLDER) build
	make -C $(BACKEND_FOLDER) build

build-and-push:
	make -C $(FRONTEND_FOLDER) build-and-push
	make -C $(BACKEND_FOLDER) build-and-push

push:
	make -C $(FRONTEND_FOLDER) push
	make -C $(BACKEND_FOLDER) push