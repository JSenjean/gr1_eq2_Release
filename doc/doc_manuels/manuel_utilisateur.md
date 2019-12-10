Dernière mise à jour : 09/12/2019 - Sprint3.v0.3.0

# Inscription

Pour s'inscrire sur le site, cliquer sur un des deux boutons 'Inscription' de la page d'accueil, remplir le formulaire avec des informations valides comme indiqué par les aides interactives, puis cliquer sur le bouton 'Inscription'. On considérera dans la suite de ce manuel que l'utilisateur dispose d'un compte inscrit.


# Connexion

Pour se connecter sur le site, cliquer sur un des deux boutons 'Connexion' de la page d'accueil, remplir les formulaires avec les identifiants utilisés à l'inscription, puis cliquer sur le bouton 'Connexion'. On considérera dans la suite de ce manuel que l'utilisateur est connecté.


# Page Mes Projets

La page mes projets donne une vue d'ensemble des projets dont l'utilisateur est membre ou chef, ainsi que des projets à la visibilité publique dont il n'est pas membre.

## Créer un projet

Pour créer un nouveau projet, cliquer sur le bouton "Créer un nouveau projet", remplir le formulaire avec les informations souhaitées, puis valider. Si la case "Public ?" n'est pas cochée, les autres utilisateurs ne pourront pas rechercher ce projet dans la liste et demander à le rejoindre, ils devront être invités.

## Rechercher un projet

La section de droite de cette page est une liste avec moteur de recherche de tous les projets publics existants dont l'utilisateur courant n'est pas membre. En cliquant sur le bouton "Demander à rejoindre", l'utilisateur enverra une requête au chef du projet correspondant. Le nom d'utilisateur du chef de projet est affiché sur chaque carte de projet.

## Gérer un projet - Membre

Si l'utilisateur est membre d'un projet sans en être le propriétaire, il disposera de 2 boutons sur la carte d'un tel projet, un pour quitter le projet, et l'autre pour rentrer dans sa vue détaillée.

## Gérer un projet - Chef

Si l'utilisateur est chef d'un projet, il dipose de 3 boutons. Une icône de couronne jaune indique à l'utilisateur les projets dont il est le chef. La flèche verte en bas à droite de la carte du projet permet de rentrer dans la vue détaillée. L'icône de poubelle rouge permet de supprimer le projet (une fenêtre de confirmation apparaîtra car l'action est irréversible). L'icône de croix bleue permet d'afficher une fenêtre de recherche de membre, pour leur envoyer des invitations à rejoindre le projet. Il est possible d'ajouter plusieurs membres à la fois.


# Vue générale

Une fois un projet sélectionné, l'utilisateur est redirigé sur la page générale du projet. Cette page donne une image d'ensemble de l'état d'avançement du projet, ses informations générales, ses membres, invitations et requêtes, et permet également la navigation dans les différentes parties du projet.

## Barre de navigation

La barre de navigation permet de se déplacer sur l'une des 6 pages de gestion de projet :
- Vue générale : la page d'accueil du projet
- Backlog : contient les User Stories et les rôles associés
- Sprints : contient la gestion des sprints, des tâches, et de leur avancement ou statut
- Tests : contient la liste et l'état de tous les tests ajoutés
- Documentation : contient la liste de tous les éléments de documentation ajoutés
- Release : contient les listes de commit et des releases du dépôt GitHub associé

## Gestion des membres

La gestion des membres regroupe 3 sections :
- Membres : les membres actuels du projet, le chef de projet est marqué d'une icône de couronne, le chef de projet à le pouvoir d'exclure des membres de son projet
- Requêtes en attente : la liste des membres ayant demandé à rejoindre le projet après avoir effectué une recherche, le chef de projet à le pouvoir d'accepter ou de refuser ces demandes individuellement
- Invitations envoyées : la liste des utilisateurs ayant reçu une invitation à rejoindre le projet de la part du chef, ce dernier peut retirer ces invitations à tout moment

## Suivi du projet

Cette section contient 3 barres de progressions permettant d'un coup d'oeil de donner un aperçu de l'état d'avancement du projet, à savoir :
- les sprints ajoutés, et leur nombre, répartis par couleur : vert - terminé, rouge - en cours, et bleu - à venir
- les tests ajoutés, et leur nombre, répartis par état en suivant le code couleur : vert - passés, rouge - échoués, orange - dépréciés, et gris - jamais exécuté
- la documentation, l'état d'avancement de la documentation du projet

## Informations générales

Cette section regroupe le titre, la description et la visibilité du projet. Ces informations peuvent être éditées par le chef de projet uniquement.


# Backlog

Cette page permet de gérer les issues d'un projet sous la forme d'User Stories, tout en gérant des rôles associés (En tant que \[rôle\], je peux ...).

## Rôles

La première action disponible sur cette page est la création de rôles, qui se fait via un formulaire proposant de renseigner un intitulé, et une description. Les rôles ainsi créés apparaîtront en haut de la page. Si l'utilisateur clique sur un de ces rôles, il peut en voir la description complète, et peut également cliquer sur les boutons 'Supprimer' et 'Modifier' pour gérer les rôles.

## User Stories

En cliquant sur l'icône de croix bleue située sous les User Stories existantes, ou sous les rôles si aucune n'a encore été créée, l'utilisateur peut remplir un formulaire pour ajouter une US, en renseignant les informations :
- Nom : un nom permettant d'identifier cette US
- Rôle : à choisir dans un menu déroulant parmi tous les rôles créés au préalable
- Terminé ? : une case à cochée pour indiquer qu'une US est achevée (ou non)
- Je peux : l'action possible pour le rôle selectionné
- Afin de : le besoin correspondant
- Effort : une valeur suivant la suite de Fibonacci pour estimer la difficulté de l'issue
- Valeur métier : à choisir dans un menu déroulant parmi les valeurs : 'LOW', 'MEDIUM', 'HIGH', 'VERY HIGH'

En passant la souris sur une US existante, on voit sa description s'afficher, ainis que les boutons permettant de la modifier ou de la supprimer.


# Sprints

Cette page permet la gestion des sprints et des tâches d'un projet. Les tâches sont associées à un sprint.

## Sprints

Pour ajouter un sprint, il faut donner un nom, une date de début, et une date de fin. Ces informations peuvent par la suite être éditées, et il est possible de supprimer un sprint. Les sprints sont affichés triés par date, et colorés suivant le code suivant : vert - terminé, rouge - en cours, et bleu - à venir. Si au moins une tâche existe, une barre de progression sera affichée pour indiquer l'avancement des tâches du sprint en question, et leur nombre par état, en suivant le code couleur : rouge - Todo, orange - Doing, et vert - Done. En cliquant sur un sprint, on peut afficher la vue détaillée de ce sprint, à savoir les User Stories associées, et les tâches créées. Il est possible d'ajouter de nouvelles US et de créer de nouvelles tâches.

## User Stories

Le bouton "Ajouter User Story" permet de selectionner une ou plusieurs US préalablement créée dans un menu déroulant pour les associer au sprint, elles seront affichées dans la colonne la plus à gauche.

## Tâches

Une tâche est associée à un sprint et donc créée directement dans la vue détaillée d'un sprint selectionné. Le formulaire de création permet de renseigner, un nom (obligatoire), une description, une 'Definition of Done', une tâche parente (ou prédecesseur), une durée (comptée en jour/homme), un membre associé, une US associée, et le type de la tâche (basique, test ou doc). Par défaut les tâches apparaîssent dans la colonne "Todo", mais peuvent être deplacées à volonté dans les colonnes "Doing" et "Done", ou revenir en arrière grâce aux flèches vertes droite ou gauche situées sur chaque carte de tâche. Cliquer sur une tâche permet de modifier ses informations, cliquer sur la croix rouge permet de l'effacer. Le placement dans les différentes colonnes d'avancement influe sur la barre de progression du sprint.

# Tests

Cette page permet d'avoir une vue d'ensemble de tous les tests ajoutés, de leur date de dernière exécution, et de leur statut (passé, échoué, deprécié, jamais exécuté).

## Barre de progression

La barre de progression résume l'état d'avancement de tous les tests, répartis en 4 catégories : verts - passés, rouges - échoués, jaune - dépréciés, et gris - jamais exécutés.

## Gestion

### Filtres

Les filtres permettent de cocher ou décocher des cases pour n'afficher que certains types de tests, par exemple, afficher uniquement les tests passés et jamais lancés. Deux boutons sont présents : 
- "Ajouter un nouveau test", permet de créer un test à partir d'un nom, d'une description, et d'un statut (passé, échoué ou jamais lancé).
- "Marquer tous les tests comme passés", permet de faire passer tous les tests présents, et d'actualiser leur date de dernière exécution à la date courante

### Etats

Cliquer sur un test permet d'étendre son affichage pour voir sa description, le modifier ou le supprimer. Chaque test dispose de deux boutons : un pour le valider, un pour le marquer comme échoué. Les tests déjà validés peuvent être validés à nouveau pour actualiser leur date d'exécution (idem pour les tests échoués). Si un test est trop ancien (durée fixée actuellement à 2 semaines), le test sera marqué comme déprécié. Les tests qui ont été marqués comme dépréciés depuis la dernière visite de la page par un utilisateur provoqueront l'affichage d'une barre d'avertissement, informant du nombre de tests nouvellement marqués comme trop anciens. Si un commit est effectué sur un dépôt associé (cf. page release), tous les tests sont marqués comme dépréciés.


# Documentation

Cette page permet d'avoir une vue d'ensemble de tous les sections de documentation ajoutées, de leur date de dernière mise à jour, et de leur statut (faite, à faire, dépréciée).

## Barre de progression

La barre de progression résume l'état d'avancement de tous les éléments de documentation, répartis en 3 catégories : verts - fait, jaune - dépréciés, et gris - à faire.

## Gestion

### Filtres

Les filtres permettent de cocher ou décocher des cases pour n'afficher que certaines documentation selon leur statut, par exemple, afficher uniquement les documentations dépréciées et à faire. Deux boutons sont présents : 
- "Ajouter une nouvelle documentation", permet de créer une doc à partir d'un nom, d'une description, et d'un statut (faite, à faire, dépréciée).
- "Marquer toutes les documentations comme terminées", permet de faire passer toutes les doc en "faites", et d'actualiser leur date de dernière exécution à la date courante

### Etats

Cliquer sur une doc permet d'étendre son affichage pour voir sa description, la modifier ou la supprimer. Chaque élément de documentation fait ou à déprécié dispose de deux boutons : un pour le marquer comme fait, un pour le marquer comme déprécié. Les éléments déjà validés peuvent être validés à nouveau pour actualiser leur date de denière mise à jour (idem pour les docs dépréciées). Si une doc est trop ancienne, (durée fixée actuellement à 2 semaines), elle sera automatiquement marquée comme dépréciée. Les docs qui ont été marquées comme dépréciées depuis la dernière visite de la page par un utilisateur provoqueront l'affichage d'une barre d'avertissement, informant du nombre d'éléments nouvellement marqués comme trop anciens.


# Release

La page de release permet d'associer un dépôt GitHub au projet, et de voir ensuite la liste des commits effectués, ainsi que les releases GitHub du dépôt.

## Commits

La liste des commits permet d'afficher l'historique d'activité du dépôt GitHub, cliquer sur un commit permet d'en afficher le contenu, et de faire apparaître un bouton permettant de les retrouver sur GitHub. Lorsqu'un nouveau commit est effectué, il sera entouré de vert, et fera passer tous les tests de la page 'Tests' en déprécié.

## Release

La liste des release permet de consulter l'ensemble des release effectuées sur le depôt GitHub, leur nom et leur date. Cliquer sur une Release permet d'afficher le README en markdown associé à la release, de voir la release directement sur GitHub (redirection), ou de télécharger son contenu au format .zip.


# FAQ

La page de FAQ est accessible même si l'on est pas authentifié. Cette page recence toutes les questions/réponses renseignées par les administrateurs du site, triées par catégories. Cliquer sur une catégorie dans la colonne de gauche permet l'affichage de toutes les questions correspondantes. Cliquer sur une question permet d'afficher la réponse.


# Page Profil

La page profil est disponible pour tout utilisateur authentifié depuis le menu déroulant en haut à droite du site. Elle permet de consulter ses informations personnelles (et de les éditer), de fermer son compte, de voir dans combien de projet l'on est membre, de voir toutes les invitations à rejoindre un projet, les demandandes effectuées pour rejoindre un projet, et de les annuler.


# Déconnexion

La déconnexion s'effectue en cliquant sur le bouton 'Déconnexion' dans le menu déroulant en haut à droite du site.