Dernière mise à jour : 09/12/2019 - Sprint3.v0.3.0

# Bugs connus

Ce fichier recense tous les bugs d'utilisation connus à destination des utilisateurs, ainsi que la manière de les contourner jusqu'à ce qu'ils soient fixés.

# Menu déroulant en haut à droite ne fonctionnant pas sur la page d'accueil une fois connecté

## Bug
Sur la page "Mes Projets", qui est aussi la page d'accueil qui s'affiche une fois connecté, le menu déroulant en haut à droite de l'écran n'est pas cliquable et ne peut donc pas afficher les éléments du menu.

## Solution de contournement
Ce menu se déroulera normalement sur n'importe quelle autre page du site, il suffit donc temporairement de se rendre sur une autre page, comme la page de la FAQ, pour utiliser ce menu.

## Origine du problème
La recherche de projet utilise des fonctionnalités de la bibliothèque beta de 'Bootstrap' 4 alors que le reste du site utilise la version stable de cette même bibliothèque. Cette page inclus 2 versions différentes de la même bibliothèque et provoque donc des conflits.


# Ajout de membre depuis la vue générale d'un projet sélectionné

## Bug
Sur la page "Vue générale" d'un projet préalablement sélectionné, le bouton "Ajouter des membres" ne fonctionne pas.

## Solution de contournement
Privilégier l'ajout de membre directement depuis la page précédente : "Mes Projets", en cliquant sur l'icône de croix bleue.

## Origine du problème
Le bouton n'a pas encore été associé aux fonctions d'ajout de membre.


# Cliquer sur un sprint nécessite de recharger la page si l'on veut modifier les informations d'un autre sprint

## Bug
Sur la page des Sprints, si l'on selectionne un sprint (en cliquant dessus), il ne sera pas possible de modifier les informations d'un autre sprint (après avoir cliqué dessus) sans recharger la page. Il n'y a pas de problèmes si il s'agit uniquement de consulter les informations d'un autre sprint.

## Solution de contournement
Recharger la page.

## Origine du problème
Les boutons d'actions à l'intérieur d'un sprint gardent leur identifiant associé à la selection du sprint, et ne sont pas rechargés lorsque l'on change de sprint.
