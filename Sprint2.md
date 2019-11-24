# Sprint 2

## Dates

Du Mardi 12 Novembre 2019 au Vendredi 22 Novembre 2019

## Résumé

Le sprint 2 est centré sur l'implémentation des fonctionnalités de gestion du Backlog, du Sprint et des tâches, ainsi que sur la mise en place des tests unitaires et des tests de validation.
## Issues

### IDs

Les issues sélectionnées pour ce sprint sont les issues 4 à 10 (incluant celles reportées depuis le sprint 1) et 12 à 21.

### Détail

| ID     | Description                                   | Difficulté | Priorité | Sprint |
|--------|-----------------------------------------------|------------|----------|--------|
| US4    | **En tant que** utilisateur                   | 3          | HIGH     | 1 & 2  |
|        | **je peux** créer un projet sur la page projet, en renseignant son nom, sa description, et sa visibilité \(est\-ce qu'il apparaîtra dans la recherche des utilisateurs\)
|        | **afin de** devenir chef de ce projet 
| US5    | **En tant que** chef de projet                | 2          | HIGH     | 1 & 2  |
|        | **je peux** modifier les informations d'un projet depuis la page de gestion de projet en cliquant sur le bouton d'options\. je peux ensuite modifier les champs nom et description du projet\. Depuis le résumé d'un projet je peux aussi supprimer un projet en cliquant sur la bouton de suppression
|        | **afin de** éditer ou de supprimer un projet
| US6    | **En tant que** chef de projet                | 3          | HIGH     | 1 & 2  |
|        | **je peux** inviter des utilisateurs à rejoindre un projet en cliquant sur ajouter des membres puis je renseigne les noms des utilisateur que je souhaite ajouter
|        | **afin de** les ajouter au projet
| US7    | **En tant que** utilisateur                   | 5          | HIGH     | 1 & 2  |
|        | **je peux** rechercher un projet par son nom grâce a la barre de recherche de projet
|        | **afin de** demander a le rejoindre
| US8    | **En tant que** utilisateur                   | 3          | HIGH     | 1 & 2  |
|        | **je peux** demander a rejoindre un projet depuis ma page utilisateur grâce à la recherche de projet, je renseigne le nom du projet et je choisi de rejoindre celui que je veux dans la liste, ce qui envoie une demande d'invitation au projet
|        | **afin de** rejoindre un projet
| US9    | **En tant que** membre d'un projet            | 2          | HIGH     | 1 & 2  |
|        | **je peux** me désinscrire d'un projet en cliquant sur mes projet puis sur ce desinscrire ou alors depuis la page de gestion du projet en cliquant sur quitter projet\.
|        | **afin de** ne plus participer a ce projet
| US10   | **En tant que** chef de projet                | 3          | HIGH     | 1 & 2  |
|        | **je peux** nommer un nouveau chef de projet depuis la page de gestion du projet en cliquant sur transférer le rôle de chef de projet et choisir dans la liste des membres le nouveau chef
|        | **afin de** transferer les droits à un autre membre 
| US12   | **En tant que** participant                   | 3          | HIGH     | 2      |
|        | **je peux** créer une user story sur la page backlog en cliquant sur le bouton, puis lui ajouter un identifiant et remplir les champs de nom et description, ainsi qu'associé un effort et une valeur métier et enfin valider la création\. je peux aussi associer un rôle défini dans la page du backlog comme par exemple "Visiteur" ou "Utilisateur"
|        | **afin de** ajouter une nouvelle user story
| US13   | **En tant que** participant                   | 2          | HIGH     | 2      |
|        | **je peux** définir des rôles pour les users story en cliquant sur le bouton d'ajout en entrant les informations nécessaires :
|        | - Un nom de rôle
|        | - Une description
|        | Le rôle sera ajouté à la suite des rôles existants, que je peux modifier ou supprimer en cliquant sur les boutons correspondants
|        | **afin de** pouvoir les afficher et les associer à des users stories
| US14   | **En tant que** participant                   | 2          | HIGH     | 2      |
|        | **je peux** modifier ou supprimer une user story en cliquant sur cette user story, la page de modification apparait ce qui me permet de changer la description, le nom ou ajouter un role puis cliquer sur valider\.
|        | Sinon je peux cliquer sur le bouton supprimer\.
|        | **afin de** d'éditer ses informations ou de la supprimer
| US15   | **En tant que** participant                   | 5          | HIGH     | 2      |
|        | **je peux** ajouter un nouveau sprint avec un nom, une date de début et une date de fin\. Je pourrais voir mon sprint aligné avec les autres, triés par ordre de date de début\. je peux également voir les sprints finis \(en vert\), les sprints censés être terminés mais pas achevés \(rouge\), le sprint correspondant à la date actuelle \(en bleue\), et les sprints futurs \(en blanc\)
|        | **afin de** créer et voir les sprints du projet
| US16   | **En tant que** participant                   | 2          | HIGH     | 2      |
|        | **je peux** cliquer sur le bouton de modification de la vue réduite du sprint, ce qui permet de modifier le nom, la date de début et de fin\. Sinon je peux cliquer sur le bouton supprimer\.
|        | **afin de** actualiser les informations du sprint ou de le retirer de la liste des sprints
| US17   | **En tant que** participant                   | 5          | HIGH     | 2      |
|        | **je peux** cliquer sur un sprint, pour étendre son affichage et avoir accès à la liste des user stories correspondantes, des tâches à faire, des tâches en cours de réalisation, et des tâches terminées \(les tâches marquées comme terminées contribuent à augmenter le pourcentage d'accomplissement du sprint\)\. je peux également ajouter ou supprimer les user stories associées en cliquant sur les boutons correspondants
|        | **afin de** gérer en détail les tâches à réaliser durant le sprint
| US18   | **En tant que** participant                   | 3          | HIGH     | 2      |
|        | **je peux** ajouter une tâche dans la colonne des tâches à faire, en renseignant les informations suivante :
|        | - Un identifiant
|        | - Un titre
|        | - Une description
|        | - Une definition of done \(DoD\)
|        | - \(Optionnel\) Un fichier \(maquette, \.\.\.\)
|        | - \(Optionnel\) Une tâche parente 
|        | - Une ou plusieurs user stories associée\(s\)
|        | **afin de** créer de nouvelles tâches pour ce sprint
| US19   | **En tant que** participant                   | 3          | HIGH     | 2      |
|        | **je peux** déplacer les tâches d'une colonne à une autre en utilisant les flèches sur chaque tâche
|        | **afin de** indiquer et mettre à jour le statut des tâches durant le déroulement du sprint
| US20   | **En tant que** participant                   | 3          | HIGH      |
|        | **je peux** créer/modifier un test sur la page dédiée en renseignant les informations suivantes
|        | - Un nom
|        | - Une description
|        | **je peux** également supprimer un test en cliquant sur le bouton correspondant d'un test
|        | **afin de** ajouter a la liste des tests
| US21   | **En tant que** participant                   | 5          | HIGH      |
|        | **je peux** marquer un test comme fait \(vert\), la date de dernière validation sera alors affichée sur ce test\. Si un commit est effectué sur le dépôt de release \(voir page release\), tous les tests sont marqués comme non validés \(rouge\)
|        | **afin de** avoir un suivi précis de tous les tests, effectués ou non, et si ils ont été validés depuis la dernière mise à jour ou non