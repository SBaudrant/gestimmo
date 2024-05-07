# Application Gestimmo 

Outil de gestion immobilier pour la location.

Fonctionnalités :

- Email automatiques au propriétaire pour le relancer au moment des échéances
- Génération automatique des quittances
- Stockages des quittances
- Envoie des quittances à la demande
- Dashboard de suivi des locations et des rentes par mois / année / bien (pour faciliter les déclarations etc)

## Wiki

Les documentations supplémentaires et recettes se trouvent dans le wiki afin de ne pas polluer le squelette.  
https://gitlab.a5sys.com/a5sys/a5sys-app-starter-kit/wikis

## Process d'initialisation d'un projet

* Mettre le logo du client ici : `frontend/src/assets/img/logo.png`
* Et le favicon ici : `frontend/src/favicon.ico`
* Vérifier que tous les scripts *.sh sont exécutables (dans scripts/, backend/docker/entrypoint/ et frontend/docker/entrypoint)
* Vérifier que la console symfony et phpunit ont les droits d'exécution (backend/bin/console et backend/bin/phpunit)
* Build les images Docker
  * `make backend build`
  * `make frontend build`
* Lancer les images Docker, vérifier que l'appli fonctionne correctement
  * `make up`
* Push les images Docker sur le registry GitLab
  * `make backend push`
  * `make frontend push`
* Commit & push les sources

## Fonctionnalités du backend

* Dernière version de Symfony + API Platform
* API Platform branché sur une base PostgreSQL
* JWT activé et configuré
* Une classe User
* Des utilisateurs de test (fixtures)
* Des tests PHPUnit de l'API

## Fonctionnalités du frontend

* Dernière version d'Angular + Angular-Material
* Mode HMR activé pour des rebuilds plus rapides (attention a bien unsubscribe dans les ngOnDestroy)
* SCSS
* Ecran de connexion
* Layout header menu + footer
* Page d'accueil
* Ecran d'administration de gestion des utilisateurs
* Stockage dans le localStorage de l'utilisateur et du token JWT
* Interceptor pour les erreurs serveur et la gestion du token expiré
* Compodoc

## Build et déploiement

Le build et le déploiement sont gérés automatiquement par GitLab CI à chaque tag.

## Conventions de dev

* EditorConfig (IDE)
* PHPCS (IDE + GitLab CI)
* TSLint (IDE + GitLab CI)
* Stylelint (IDE + GitLab CI)

## Précision sur la gestion des images Docker

Dans le Makefile, par défaut le run s'appuie sur les images *locales* si elles existent. Il est donc possible de faire un build local, puis un run. Cela permet de travailler en local le temps de finaliser sa configuration, avant d'envoyer au registry GitLab.

Pour forcer la mise à jour depuis et vers le registry, il faut utiliser les commandes pull et push (ou build-and-push).

## Références des bonnes pratiques

* https://angular.io/guide/styleguide
* https://symfony.com/doc/current/contributing/code/standards.html
* https://github.com/A5sys/A5sys-coding-standard
* https://github.com/A5sys/AngularTslintRules
* https://gitlab.a5sys.com/a5sys/a5-standards

# CI-DESSOUS = A LAISSER DANS LE README DU PROJET

## Utilisation des commandes make pour lancer l'environnement de développement

Prérequis : 
* On utilise majoritairement WSL2 pour faire tourner Docker désormais, c'est le standard chez A5sys (exit les vieilles VM Linux)
* Une doc d'installation est dispo sur SP : https://intranet.a5sys.com/wikideveloppement/Pages/Installation-WSL2.aspx
* Il faudra également installer `make` dans WSL2 pour exécuter les commandes 
* Les sources doivent être clonées **dans** WSL2 directement (pas dans Windows)

* `make up` démarre le backend et le frontend
* `make backend up` démarre le backend sur https://localhost:8000
* `make frontend up` démarre le client sur http://localhost:4200

Utilisateurs de test pour se connecter :
* admin@test.com / pass
* user@test.com / pass

## Commandes Symfony / Angular

Toujours exécuter les commandes Symfony/Angular depuis les containers.  
Exemple : `composer require`, `npm install`, etc.

Pour ce faire, utiliser les commandes :  
`make backend exec-root-bash` pour composer, psalm, etc. (les commandes qui ont besoins du système de fichier en plus des fichiers du projet pour fonctionner)
`make backend exec-bash` pour les commandes symfony `php bin/console ...` (toutes les commandes qui agissent seulement avec les fichiers du projet)
`make frontend exec-bash`  

## Outils de développement

Pour voir toutes les commandes disponibles :  
`make help`
`make backend`
`make frontend`

Il y a notamment un outil de génération de doc pour la partie Angular qui permet de voir le schéma des dépendances et plein d'autres choses :  
`make frontend doc`

## Utilisation de material-icons en mode Offline

Ajouter dans la package.json cette library :
```https://github.com/marella/material-design-icons```

Ne pas oublier d'inclure les icônes dans le fichier css _main.scss
```@import '@material-design-icons/font';```

## Utilisation du système de grille Bootstrap

Aller voir sur l'url
```https://getbootstrap.com/docs/5.1/layout/grid/```
