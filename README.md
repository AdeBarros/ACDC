# ACDC

Prototype d'interface numérisée pour la retranscription ACDC


## Installation :

XAMPP :  
Télécharger : https://www.apachefriends.org/fr/index.html  
Utilisation : Lancer XAMPP Control Panel, activer Apache (pour le PHP) et MySql (pour la BDD)  

Base de Données :  
Accès : http://localhost/phpmyadmin/server_import.php
Importer : acdc.sql (présent dans ce dossier)

Flask :  
Lancer son invite de commande / bash (ou invite python pour Windows)  
Se placer dans le dossier courant  
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
