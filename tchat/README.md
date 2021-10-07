# Documentation Projet chat

## Prérequis

- Symfony
- NPM ou YARN
- Git
- Composer
- Un éditeur de code
- Un serveur de base de données

## Installation du projet depuis Gitlab GAEA21

## Lancement du projet sur son PC

Une fois le projet cloner le lancer dans son éditeur de code.

Ouvrir un terminal Bash de préférence et lancer la commande

```bash
composer install 
```

Attendre que composer installe toutes les dépendances

vérifier le fichier '.env'

et modifier la dernière ligne en fonction de votre installation

retournez dans votre terminale utiliser la commande de création de base de données :

```bash
php bin/console doctrine:database:create
```

puis lancer dans ce même Bash

```bash
npm install 
```

Puis lancer le server Symfony :

```bash 
symfony server:start
```

Regarder dans son navigateur si le tout fonctionne

La suite : Faire en sort que l'echange soit plus fluide et que les requetes JS se lancent que losqu'on envoit un message
et non se refraichir en permanence 