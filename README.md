# ACDC
Prototype d'interface numérisée pour la retranscription ACDC

## Installation Windows / MacOS :
### XAMPP :
Télécharger : https://www.apachefriends.org/fr/index.html
Utilisation : Lancer XAMPP Control Panel, activer Apache (pour le PHP) et MySql (pour la BDD)
### Python :
Téléchager Python 3 (latest version) : https://www.python.org/downloads/
Installer pip : https://pypi.org/project/pip/
(optionnel) : Installer Anaconda Navigator - https://docs.anaconda.com/anaconda/navigator/install/
#### Plotly :
Installer : https://plotly.com/python/getting-started/#installation
invite de commande python (pip)
```
pip install plotly
```

### Flask :
Installer : https://flask.palletsprojects.com/en/2.0.x/installation/#install-flask
invite de commande python (pip) 
```
pip install flask 
```

### Code-ci :
Extraire l'archive ACDC dans le répertoire C:\xampp\htdocs
ou
```
git clone https://github.com/AdeBarros/ACDC.git
```

### Base de Données :
Accès : http://localhost/phpmyadmin/server_import.php
Importer : acdc.sql (présent dans ce dossier)
ou
Copier-coller son contenu dans l'onglet "SQL" : http://localhost/phpmyadmin/server_sql.php
### Utilisation :
#### Flask :
Lancer son invite de commande python / bash (pip)
Se placer dans le dossier courant (C:\xampp\htdocs\JS sur windows)
Lancer les lignes suivantes (en fonction de l'invite en question):
&nbsp;&nbsp; Bash :
```bash
export FLASK_APP=dataviz
flask run
```
Python cmd (pip) :
```
set FLASK_APP=dataviz
flask run
```
&nbsp;&nbsp; PowerShell :
```powershell
$env:FLASK_APP = "dataviz"
lask run
```

#### Consulter :
Ouvrir le fichier "main.php" dans un navigateur : http://localhost/ACDC/templates/main.php

## Installation Linux

	git clone https://github.com/AdeBarros/ACDC.git

### Serveur

**Note:** apache2 vient comme dépendence de `PHP7.x`.

```bash
apt install php7.4
```

### Base de données (BDD)

MySQL `v8.x` with binding for PHP

```bash
apt install \
	mysql-server \
	php7.4-mysql 
```

### Python
 ```bash
apt install \ 
	python3.8 \ 
	python3-pip
 ```

#### Packages Python

* [Plotly][plotly] pour les graph
* [Flask][flask] pour générer la dataviz

```bash
python3 -m pip install \
	flask \
	flask_cors \
	plotly \
	--user
```

### Configuration

#### Apache

Placer le code dans le répertoire publique d’apache (ou configurer un virtualhost), par exemple avec un lien symbolique :

```bash
ACDC/ $
sudo ln -nfs $PWD /var/www/html/
```

On obtient :

```bash
$ tree /var/www/html/ -L  1 
/var/www/html/
├── ACDC # lien symbolique vers le code
└── index.html
```

Relire la config d’apache pour le prendre en compte

```bash
sudo service apache2 reload
```

#### MySQL

[Créer la base][mysql-create-db] de données `acdc` et les tables en [important le fichier `.sql`][mysql-import-file]

    sudo mysql -u root -p < ./acdc.sql


[Vérifier][mysql-list-db] que la base a été créée avec:

```bash
$ sudo mysql -u root -p -e "SHOW DATABASES;"
Enter password:
+--------------------+
| Database           |
+--------------------+
| acdc               |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
```

### Utilisation

#### Démarrer le server de dataviz

```bash
export FLASK_APP=dataviz
python3 -m flask run
```

#### Consulter

Le fichier `./templates/main.php` doit être interprété par le serveur et accessible à une adresse du type : http://localhost/ACDC/templates/main.php

### Références

[mysql-create-db]: https://stackoverflow.com/a/5774940
[mysql-list-db]: https://www.liquidweb.com/kb/show-list-mysql-databases-on-linux-via-command-line/
[mysql-import-file]: https://askubuntu.com/a/948906
[plotly]: https://plotly.com/python/getting-started/#installation
[flask]: https://flask.palletsprojects.com/en/2.0.x/installation/#install-flask
