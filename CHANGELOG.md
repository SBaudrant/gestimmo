# Changelog

- 2023/08/16 : (*infrastructure*) Amélioration du README.md Ansible
- 2023/07/25 : (*infrastructure*) Installation d'ansible pour automatiser l'installation et la configuration des serveurs
- 2023/06/14 : (*backend*) Amélioration de la méchanique d'authentification dans les tests
- 2023/05/31 : (*backend*) Mise à jour vers Symfony 6.3 
- 2023/05/16 : (*frontend-angular*) Ajout de Stylelint au devDependencies au lieu d'une image docker
- 2023/05/16 : (*frontend-angular*) Mise à jour d'Angular de la version 15 vers la version 16
- 2023/05/16 : (*backend*) Mise à jour de PostgreSQL de la version 14 vers la version 15
- 2023/05/16 : (*Docker*) Amélioration des images de lint/test 
- 2023/05/16 : (*CI/CD*) Build automatique des images docker lors des changements sur les fichiers intéressants
- 2023/05/16 : (*CI/CD*) Utilisation du docker-executor pour les job lint/tests
- 2023/02/21 : (*CI/CD*) Correction des codes d'erreur 1 pour les commandes Makefiles dans les sous-dossiers sur Gitlab
- 2023/02/21 : (*frontend-angular*) Amélioration du Makefile (utilisation de l'UID de l'utilisateur courant, ajout d'eslint)
- 2023/02/21 : (*backend*) Amélioration du Makefile (utilisation de l'UID de l'utilisateur courant, ajout de phpc(s/bf))
- 2023/02/16 : (*backend*) (*docker*) Utilisation de l'image nginx sans Dockerfile, utilisation de l'image interne partagée PostgreSQL 14. 
- 2023/02/16 : (*backend*) Ajout de [PHPStan](https://phpstan.org/). 
- 2023/02/13 : (*backend*) On utilise maintenant des operations PATCH au lieu de PUT pour mettre à jour partiellement une ressource. 
- 2023/02/13 : (*backend*) Verification qu'on n'utilise pas de "soft dependency" dans notre code.
