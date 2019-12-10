Dernière mise à jour : 09/12/2019 - Sprint3.v0.3.0

# Manuel administrateur

## Installation du site

### Docker

Docker peut être utilisé pour déployer le site :
Depuis la racine, lancer la commande :
```bash
docker-compose up --build
```


### Installation manuelle

Le code du site est contenu dans le dossier **/src** et doit être hébergé sur un serveur php.

La base de données peut être installée avec le fichier **/src/bdd.sql**, qui contient la base de données vide du site, avec les instructions sql pour créer une base nommée 'cdp', ainsi que toutes les tables nécessaires au fonctionnement du site. Un utilisateur avec les privilèges administrateurs sera alors créé, ses identifiants de connexion étant 'admin' et 'admin'.

Pour connecter l'application à la base de données, il est nécessaire de paramétrer la connexion dans le fichier **/src/config.ini**. Différents exemples d'utilisations de ce fichier sont présentés dans le fichier **/doc/configs\_bdd.md**.


## Panneau d'administration

Après la mise en place du site et la création de la base de données avec le fichier **/src/bdd.sql**, il est possible de se connecter une première fois directement en utilisant le compte administrateur par défaut : 'admin', 'admin'.

Par rapport aux utilisateurs normaux, les administrateurs disposent d'un bouton supplémentaire dans le menu déroulant en haut à droite, qui leur permet d'accéder au "panneau d'administration". Cette page recense tous les utilisateurs du site et leurs informations. Pour chaque utilisateur, les administrateurs ont 2 actions possibles :
- Supprimer l'utilisateur : cette action effacera le compte de l'utilisateur du site, ainsi que toutes ses informations associées. Si l'utilisateur était chef d'un ou plusieurs projets, ces projets seront supprimés
- Statut Administrateur : cette action donne les privilèges administrateurs à cette utilisateur, de manière définitive (les administrateurs ne peuvent changer les droits des autres administrateurs)


## FAQ

Sur la page de la FAQ, les administrateurs disposent d'un menu déroulant supplémentaire, "Outils d'administration". Cet outil permet à un administrateur authentifié d'ajouter ou supprimer une catégorie de question, et de poster une nouvelle question/réponse dans une catégorie définie. Pour chaque élément question/réponse, l'administrateur peut également modifier la question ou la réponse, ou supprimer l'élément.
