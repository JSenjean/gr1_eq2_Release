# Conduite de Projet

## Groupe 1 Equipe 2

- Guillaume Floret
- Mathieu San Juan
- Joël Senjean


# Définition des rôles

### Visiteur
Un visiteur est une personne arrivant sur le site mais n'étant pas encore inscrite ou identifiée.

### Utilisateur
Ce rôle représente toutes les personnesqui ont un compte actif et qui sont connectés sur le site. Le rôle "existe" en dehors des projets, c'est à dire sur la page d'accueil et dans la navigation générale du site.

### Chef de Projet
Représente un utilisateur qui a créé un nouveau projet. En tant que créateur et chef, il est celui qui gère l'administration du projet, et a plus de droits que les autres membres. Il a la possibilité de transmettre son rôle à un autre membre (un seul chef peut exister simultanément par projet).

### Membre
Ce rôle regroupe tous les membres d'un projet n'étant pas chef de ce projet. Ils ont des droits plus limités que le chef et ne peuvent rejoindre le projet qu'avec son accord (invitation ou demande).

### Participant
Ce rôle regroupe le chef de projet et le membre d'un projet. Sur certains aspects du site, ils ont les mêmes droits.

### Administrateur
Les administrateurs ont les droits les plus élevés sur le site, ils ont accès à la liste des membres et à certaines de leurs informations (non-confidentielles : donc pas les mots de passe, etc ...). Ils gèrent l'administration du site.


# Backlog
| ID     | Description                                   | Difficulté | Priorité | Sprint |
|--------|-----------------------------------------------|------------|----------|--------|
| US1    | **En tant que** visiteur                      | 3          | MEDIUM   | 1      |
|        | **je peux** m'inscrire sur le site en renseignant :
|        | - Un nom d'utilisateur
|        | - Une adresse mail valide 
|        | - Une confirmation d'adresse mail
|        | - Un mot de passe
|        | - Une confirmation de mot de passe 
|        | - Vrai nom
|        | - Vrai prenom
|        | **afin de** créer et rejoindre des projets
| US2    | **En tant que** visiteur                      | 3          | MEDIUM   | 1      |
|        | **je peux** utiliser mes identifiants sur la page de connexion puis je clique sur connexion et je renseigne:
|        | - Mon login dans le champ "Identifiant ou email"
|        | - Mon mot de passe dans le champ "Mot de passe"
|        | Puis je clique sur connexion
|        | afin d'être connecté sur le site
| US3    | **En tant que** utilisateur ou administrateur | 1          | MEDIUM   | 1      |
|        | **je peux** me déconnecter en cliquant sur le bouton d'option à côté de mon nom d'utilisateur, puis je clique sur le bouton déconnexion
|        | **afin de** ne plus être identifié sur le site
| US4    | **En tant que** utilisateur                   | 3          | HIGH     | 1      |
|        | **je peux** créer un projet sur la page projet, en renseignant son nom, sa description, et sa visibilité \(est\-ce qu'il apparaîtra dans la recherche des utilisateurs\)
|        | **afin de** devenir chef de ce projet 
| US5    | **En tant que** chef de projet                | 2          | HIGH     | 1      |
|        | **je peux** modifier les informations d'un projet depuis la page de gestion de projet en cliquant sur le bouton d'options\. je peux ensuite modifier les champs nom et description du projet\. Depuis le résumé d'un projet je peux aussi supprimer un projet en cliquant sur la bouton de suppression
|        | **afin de** éditer ou de supprimer un projet
| US6    | **En tant que** chef de projet                | 3          | HIGH     | 1      |
|        | **je peux** inviter des utilisateurs à rejoindre un projet en cliquant sur ajouter des membres puis je renseigne les noms des utilisateur que je souhaite ajouter
|        | **afin de** les ajouter au projet
| US7    | **En tant que** utilisateur                   | 5          | HIGH     | 1      |
|        | **je peux** rechercher un projet par son nom grâce a la barre de recherche de projet
|        | **afin de** demander a le rejoindre
| US8    | **En tant que** utilisateur                   | 3          | HIGH     | 1      |
|        | **je peux** demander a rejoindre un projet depuis ma page utilisateur grâce à la recherche de projet, je renseigne le nom du projet et je choisi de rejoindre celui que je veux dans la liste, ce qui envoie une demande d'invitation au projet
|        | **afin de** rejoindre un projet
| US9    | **En tant que** membre d'un projet            | 2          | HIGH     | 1      |
|        | **je peux** me désinscrire d'un projet en cliquant sur mes projet puis sur ce desinscrire ou alors depuis la page de gestion du projet en cliquant sur quitter projet\.
|        | **afin de** ne plus participer a ce projet
| US10   | **En tant que** chef de projet                | 3          | HIGH     | 1      |
|        | **je peux** nommer un nouveau chef de projet depuis la page de gestion du projet en cliquant sur transférer le rôle de chef de projet et choisir dans la liste des membres le nouveau chef
|        | **afin de** transferer les droits à un autre membre 
| US11   | **En tant que** participant                   | 3          | HIGH     | 1      |
|        | **je peux** avoir une vue d'ensemble du projet depuis la page de gestion de projet, ce qui affiche les informations suivantes :
|        | - la liste des membres du projet
|        | - les demandes actuelles des utilisateurs pour rejoindre le groupe 
|        | - les invitations en attente, envoyées par le chef de projet aux utilisateurs
|        | - vue d'ensemble du sprint courant \(dates, tâches restantes\)
|        | - récapitulatif des tests \(% executé\)
|        | - le nom, la description et la visibilité du projet
|        | afin d'avoir une vue d'ensemble du projet
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
| US20   | **En tant que** participant                   | 3          | LOW      |
|        | **je peux** créer/modifier un test sur la page dédiée en renseignant les informations suivantes
|        | - Un nom
|        | - Une description
|        | **je peux** également supprimer un test en cliquant sur le bouton correspondant d'un test
|        | **afin de** ajouter a la liste des tests
| US21   | **En tant que** participant                   | 5          | LOW      |
|        | **je peux** marquer un test comme fait \(vert\), la date de dernière validation sera alors affichée sur ce test\. Si un commit est effectué sur le dépôt de release \(voir page release\), tous les tests sont marqués comme non validés \(rouge\)
|        | **afin de** avoir un suivi précis de tous les tests, effectués ou non, et si ils ont été validés depuis la dernière mise à jour ou non
| US22   | **En tant que** chef de projet                | 3          | LOW      |
|        | **je peux** ajouter un dépôt git de release dans la page de gestion de version \(ou page de release\)
|        | **afin de** rendre consultable l'historique des versions de release
| US23   | **En tant que** participant                   | 1          | LOW      |
|        | **je peux** consulter la page de gestion de version
|        | **afin de** voir toutes les releases du projet
| US24   | **En tant que** participant                   | 3          | LOW      |
|        | **je peux** ajouter/modifier une section de documentation sur la page dédiée en cliquant sur ajouter/modifier une documentation en renseignant :
|        | - Un nom
|        | - Une description
|        | - Une catégorie
|        | - \(Optionnel\) Un fichier \.md associé
|        | La date de dernière modification est affichée pour chaque élément de documentation\. Si la documentation n'a pas changé depuis 1, 2, 3 ou 4 semaines, l'élément dans la liste change de couleur \(vert, bleu, orange et rouge\)\.
|        | **afin de** indiquer qu'un élément de documentation est fait, et si il est ancien ou non \(et donc potentiellement obsolète\)
| US25   | **En tant que** participant                   | 3          | LOW      |
|        | **je peux** ajouter/modifier/supprimer une catégorie de documentation sur la page dédiée en cliquant sur les boutons correspondants
|        | **afin de** organiser les différentes sections de documentation
| US26   | **En tant que** participant                   | 2          | LOW      |
|        | **je peux** cliquer sur une section de documentation pour ouvrir le details ce qui permet de cliquer sur le bouton supprimer
|        | **afin de** supprimer de la liste les documentation obsolètes
| US27   | **En tant que** utilisateur                   | 3          | LOW      | 1      |
|        | **je peux** accéder à ma page de profil, et éditer mes informations personnelles \(pénom, nom, adresse email, mot de passe\), consulter mes invitations à rejoindre des projets, et fermer mon compte sur le site 
|        | **afin de** gérer ou supprimer mes informations personnelles et mon compte
| US28   | **En tant que** administrateur                | 3          | LOW      | 1      |
|        | **je peux** accéder au panneau d'administration pour consulter la liste de tous les membres du site, changer leur rôle \(les passer administrateur\), et les supprimer du site
|        | **afin de** administrer le site
| US29   | **En tant que** visiteur ou utilisateur       | 2          | LOW      | 1      |
|        | **je peux** lire les questions fréquemment posées et leur réponse dans la FAQ
|        | **afin de** trouver des indications sur la manière d'utiliser le site
