# BIenvenue !

## Comment lancer le projet ?

### 0. Prérequis
- Docker
- Git

### 1. Cloner le projet
````
git clone [url]
````


### 2. Créer un fichier .env à la racine du projet qui contient ceci :
````
MYSQL_DATABASE=db
MYSQL_USER=user
MYSQL_PASSWORD=pass
MYSQL_ROOT_PASSWORD=root
WEB_PORT=5555
````

### 3. Lancer le docker compose avec le script ./start.sh (".\startPS.ps1" avec PowerShell sur windows) avec docker d'allumer ou installer
````
./start.sh
````
ou
### 4. Go 
http://localhost:5555/views/

## StoryBook :
````
http://localhost:5555/views/StoryBook/StoryBookBis.php
````

Le storybook présente les éléments de l'application sous forme de composants. Il permet de visualiser les éléments de l'application de manière isolée. ainsi que les couleurs, textes et titres

Il montre également la manière dont les composants sont importé dans les vues de l'appli
Le StoryBook est une vue de l'appli


# Extension utile sur vscode 
- PHP html in string, pour colorer le html dans les fichiers php
- Live Sass Compiler, pour compiler le scss en css lorsque tu enregistre ton fichier, il le fait tout seul

