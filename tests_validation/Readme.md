# Installer les prérequis

- Installer Python 2.7 ou 3.5+
- Installer les dépendances du script :
```bash
pip install pytest
pip install selenium
```
- Télécharger __chromedriver__ : https://chromedriver.chromium.org/downloads
- Ajouter __chromedriver__ au path : https://zwbetz.com/download-chromedriver-binary-and-add-to-your-path-for-automated-functional-testing/

# Lancer les tests de validation

- Définir une url où le site est hébergé dans le fichier url.txt
- Lancer le script de test avec la commande suivante :
```bash
python tests.py
```

Les logs sont consultables dans le dossier __log/__ (nouvellement créé s'il n'existait pas auparavant) 

Le nom des fichiers suit ce format : __log\_\[année\]\[mois\]\[jour\]-\[heure\]\[minutes\]\[secondes\].txt__

Cela permet d'avoir un suivi dans le temps du résultat de l'exécution des tests