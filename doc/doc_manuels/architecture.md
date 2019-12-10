Dernière mise à jour : 09/12/2019 - Sprint3.v0.3.0

# Architecture

Le code du projet est contenu dans le dossier **/src**.

## MVC

Le projet est bâti en suivant l'architecture Model/View/Controller, en utilisant les languages PHP, HTML/CSS/Bootstrap, et SQL.

- Le dossier **/controller** contient le routeur du site, **/controller/index.php**, ainsi que toutes les gestions de redirections et de changements de pages pour les autres éléments du site.
- Le dossier **/model** contient toutes les fonctions PHP de l'application, permettant principalement la communication avec la base de données
- Le dossier **/view** contient toutes les pages d'affichage du site

## Autres

- Le fichier **bdd.sql** contient la base de données, incluant les insctructions SQL pour la créer, avec toutes ses tables, et un premier utilisateur administrateur
- **docker-compose.yml**, **Dockerfile** et **Dockerfile.bdd** contiennent les images nécessaires au déploiement Docker et leur configuration
- La connexion à la base de donnée se paramètre dans le fichier **config.ini**
- Le fichier **config.ini** est protégé par le fichier **.htaccess**
