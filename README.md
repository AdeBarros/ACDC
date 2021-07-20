# ACDC

Prototype d'interface numérisée pour la retranscription ACDC


## Installation :

XAMPP :  
Télécharger : https://www.apachefriends.org/fr/index.html  
Utilisation : Lancer XAMPP Control Panel, activer Apache (pour le PHP) et MySql (pour la BDD)

Plotly :
Installer : https://plotly.com/python/getting-started/#installation
&nbsp;&nbsp; invite de commande python (pip)
&nbsp;&nbsp;&nbsp;&nbsp; pip install plotly

Flask :
Installer : https://flask.palletsprojects.com/en/2.0.x/installation/#install-flask
&nbsp;&nbsp; invite de commande python (pip)
&nbsp;&nbsp;&nbsp;&nbsp; pip install flask

Code-ci : Extraire l'archive ACDC dans le répertoire C:\xampp\htdocs

Base de Données :  
Accès : http://localhost/phpmyadmin/server_import.php
Créer : une base de données "acdc" (en minuscules)
Importer : acdc.sql (présent dans ce dossier)

Flask :  
Lancer son invite de commande python / bash (pip) 
Se placer dans le dossier courant  (C:\xampp\htdocs\JS sur windows)
Lancer les lignes suivantes (en fonction de l'invite en question):  
 &nbsp;&nbsp; Bash :  
      &nbsp;&nbsp;&nbsp;&nbsp;  export FLASK_APP=dataviz  
      &nbsp;&nbsp;&nbsp;&nbsp;  flask run  
 &nbsp;&nbsp;   Windows cmd :  
      &nbsp;&nbsp;&nbsp;&nbsp;  set FLASK_APP=dataviz  
      &nbsp;&nbsp;&nbsp;&nbsp;  flask run  
 &nbsp;&nbsp;   PowerShell :  
      &nbsp;&nbsp;&nbsp;&nbsp;  $env:FLASK_APP = "dataviz"  
      &nbsp;&nbsp;&nbsp;&nbsp;  flask run  
 
## Lancer :
Ouvrir le fichier "main.php" dans un navigateur
