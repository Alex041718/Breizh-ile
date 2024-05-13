# Bienvenue sur cette petite doc pour les migrations SQL de l'appli :

# Sommaire

- [À quoi ça sert ?](#à-quoi-ça-sert-)
- [Comment ça marche ?](#comment-ça-marche-)
- [Exemple de contenu du fichier](#exemple-de-contenu-du-fichier-)
- [Comment sont exécuter les scripts ?](#comment-sont-exécuter-les-scripts-)
- [Comment savoir si un script a été exécuté ?](#comment-savoir-si-un-script-a-été-exécuté-)

## À quoi ça sert ? 

Imaginez que tu as besoin de rajouter une colonne dans une table. On ne peut pas toucher au script d'initialisation en le modifiant et le relançant car on perdrait toutes les données déjà présentes dans la base.
Donc la solution est de créer un script de migration qui va rajouter la colonne à la table.

## Comment ça marche ?

C'est tout bête, on crée un fichier SQL dans le dossier `migrations`. On nomme le fichier avec un nom qui décrit le but du script et on date le ficher.
Par exemple :

```202404291900-_User-ajout-colonne-animal-fav.sql```

Là la date, c'est juste le 2024/04/29 à 19h00.
Le datage est important pour l'ordre d'exécution des scripts.
Si vous en créer plusieurs de suite et qu'il faut les exécuter dans un ordre précis.
La date est écrit dans ce sen sens : Année/Mois/Jour/Heure/Minute (AAAA/MM/JJ/HH/MM) pour que les fichiers soient triés dans le bon ordre. (Avec la fonction sort() de PHP)

Exemple de contenu du fichier :

```sql
ALTER TABLE db._Client ADD COLUMN animal_fav VARCHAR(255);
```

Le ficher doit contenir une seule requête SQL / ligne.

## Comment sont exécuter les scripts ?

Les scripts sont exécutés automatiquement à chaque démarrage de l'appli.
Il y a un script PHP qui va chercher les fichiers dans le dossier `migrations` et les exécute un par un.
Il va aussi tenir à jour une table `_Migrations` dans la base de données pour savoir quels scripts ont déjà été exécutés. Si c'est le cas, il ne les exécute pas.

L'interêt de ce système est que si un developpeur a créé un script de migration pour rajouter une colonne ou autre chose, il n'a pas besoin de dire aux autres développeurs de l'exécuter. C'est automatique. Un developpeur B réccupère le script via git et lance l'appli, il n'y a rien d'autre à faire. Ainsi tout le monde est à jour.

## Comment savoir si un script a été exécuté ?
SI vous remarquez que la migration ne se passe pas bien, vous pouvez vérifier si un script a été exécuté en allant voir dans la table `_Migrations` de la base de données.
Ou alors vous pouvez executer le script php directement dans le navigateur pour voir des potentielles erreurs, car le site est pas secu dutout pour l'instant mdr
```http://localhost:5555/migration.php```
