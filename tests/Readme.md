Dernière mise à jour : 09/12/2019 - Sprint3.v0.3.0

# Tests unitaires

## Docker

**Dû à un problème de configuration, les tests ne peuvent pas être lancés avec Docker dans la version actuelle du projet**

Il est possible d'utiliser le ficher docker-compose alternatif pour forcer le lancement des tests unitaires avant celui des containers principaux. Attention ! Si les tests échouent, les containers seront fermés et il ne sera pas possible de naviguer sur le site.

Depuis la racine, lancer la commande :
```bash
docker-compose -f docker-compose.tests.yml up --build
```
L'argument ``--build`` est indispensable, même si ce n'est pas la première fois que la commande est lancée, sans quoi les tests ne se lançeront pas.


## Lancement manuel

On suppose se trouver dans un environnement UNIX pour l'utilisation des scripts suivants.
Paramétrer le fichier tests/configTest.ini suivant les paramètres de la base de données locale
Exécuter les scripts suivants depuis la racine du projet :

### Installer les dépendances
Lancer le script
```bash
./install-phpunit.sh
```

### Lancer les tests
Lancer le script
```bash
./runTests.sh
```