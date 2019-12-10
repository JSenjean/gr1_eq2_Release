Dernière mise à jour : 09/12/2019 - Sprint3.v0.3.0

# Tests de validation

## Installer les prérequis

- Installer Python 2.7 ou 3.5+
- Installer les dépendances du script :
```bash
pip install pytest
pip install selenium
```
- Télécharger __chromedriver__ : https://chromedriver.chromium.org/downloads
- Ajouter __chromedriver__ au path : https://zwbetz.com/download-chromedriver-binary-and-add-to-your-path-for-automated-functional-testing/

## Lancer les tests de validation

**Dans la version actuelle du projet, seuls les tests de validation des US 1 à 9 et 27 à 29 ont été effectués**

- Définir une url où le site est hébergé dans le fichier **/tests\_validation/url.txt**
- Lancer le script de test depuis le dossier **/tests\_validation** avec la commande suivante :
```bash
python tests.py
```

Les logs sont consultables dans le dossier __log/__ (nouvellement créé s'il n'existait pas auparavant) 

Le nom des fichiers suit ce format : __log\_\[année\]\[mois\]\[jour\]-\[heure\]\[minutes\]\[secondes\].txt__

Cela permet d'avoir un suivi dans le temps du résultat de l'exécution des tests

Note : Si les tests ne sont pas tous exécutés ensembles avec le script général, des utilisateurs peuvent subsister dans la base de données et provoquer l'échec des tests suivants. Il est recommandé de laisser ce script s'exécuter jusqu'au bout.