# Bienvenue sur la documentation de git pour notre projet

## La Documentation Git

Dans ce document j'explique comment travailler sur le projet avec git.

J'utilise les lignes de commandes git, mais vous pouvez aussi utiliser un IDE qui vous permet de faire des actions git.

Si vous utiliser un IDE noublié pas le rebase avant de push votre branche de travail.

### Résumé dde la documentation :
- Créer une nouvelle branche à partir de develop
- Travailler sur la branche créée
- Rebase votre branche de travail depuis develop(à jour)
- Push votre branche de travail sur le répo distant
- Créer une Pull Request

Si vous voyez que votre branch local de "develop" contient des commits en plus de la branche "develop" distante, n'hesitez pas à la suppimer et à la recréer à partir de la branche "develop" distante.("git fetch origin" puis "git checkout -b develop origin/develop") Cela evitera de rebase avec une branch local qui contient des commits en plus de la branch "develop" distante.

## Explication des branches
- 'main' : branche principale du projet, on l'utilisera pour les démo devant le client. On ne pushera jamais directement dessus. Ce qui veut dire que l'on ne travaillera jamais directement sur cette branche.

- 'develop' : branche de développement, c'est sur cette branche que l'on va travailler. On fera des Pull Request pour intégrer nos fonctionnalités sur cette branche.

## Comment travailler sur une nouvelle fonctionnalité ?

### 1. Créer une nouvelle branche à partir de la branche 'develop' avec un nom bien spécifique lié à une US ou un Prérequis.
```
Exemple pour une US : 3.3-Consulter-fiche-logement
Exemple pour un prérequis : FRONT-PRE-Composant-HousingCard
```

### Commande Git :


Se placer sur la branche develop
```
git switch develop
```

Récupérer les dernières modifications de develop
```
git pull
```

Créer une nouvelle branche à partir de develop

```
git checkout -b 3.3-Consulter-fiche-logement develop
```


### 2. Travailler sur la branche créée :
- Vous pouvez maintenant travailler sur votre branche. 
- Vous pouvez faire plusieurs commits pour sauvegarder vos modifications.

### 3. Pousser les modifications sur le repository distant :

Il faut d'abord s'assurer que l'on a rien en retard par rapport à la branche develop.
Car entre temps la branche develop sur le repo distant a peut être évoluée.

Se déplacer sur la branch develop :
```
git switch develop
```

Mettre à jour votre branche develop local à partir de la branche develop distante :
```
git pull
```

Maintenant votre branche develop en local est identique à celle sur github.com

On souhaite maintenant mettre à jour votre branche de travail

On se déplace sur votre branche de travail :
```
git switch 3.3-Consulter-fiche-logement
````

On va venir appliquer les nouveaux commits de develop sur votre branche de travail.

ATTENTION c'est là que des conflits peuvent arriver, dans ce cas là ils vaut mieux gérer les conflits avec un bon IDE

Pour appliquer ces nouveaux commits, on va rebase votre branche de travail depuis develop (c'est comme ça qu'on dit) :
```
git rebase develop
```

Si vous n'avez aucun conflit réjouissez vous ! 

Voilà votre branche de travail avec votre toute nouvelle fonctionalité est prêt à partir sur le répo distant sur github.com.

En fait c'est preque bon

Car si vous faites :
```
git push
```
Vous allez avoir une erreur, car votre branche de travail n'existe pas sur le répo distant.
En gros git ne sais pas trop où il doit mettre votre branche. Et va vous proposer une commande qui va créer ce lien entre votre branche de travail et le répo distant.

Mais c'est un peu chiant de le faire à chaque fois donc on va configurer git pour qu'il le fasse automatiquement.

```
git config --global push.default current
```
Cette commande n'est à faire qu'une seule fois.

Maintenant vous pouvez faire un 
```
git push
```
Si c'est la première fois, votre IDE va surement vous demander de vous authentifier sur github.com.
Avec une redirection sur internet pour vous authentifier.

Et voilà votre branche de travail est sur le répo distant.

Mais ce n'est pas encore terminer AHAH ! Il faut maintenant créer une Pull Request pour que votre code soit intégré dans la branche develop.

### 4. Créer une Pull Request

Rendez-vous sur github.com, sur la page de du répo, vous devriez voir un message qui vous propose de créer une Pull Request.

Avec un Gros bouton vert pour le faire :
```
Compare & pull request
```
(Je sais pas c'est quoi en français)

À présent il y a un minuscule formulaire à remplir, avec un titre et une description de votre PR.

(PR == Pull Request)

Dans le titre il faut qu'on ai les même info que la branche de travail, c'est à dire le numéro de l'US ou du prérequis. et un petit titre qui résume la PR.

C'est ce titre qui apparaîtra dans l'histoirique des commits de develop.

Exemple : 
```
[3.3] Ajout de la fiche logement
```

Dans la description, il faut décrire ce qui a été fait, pas un truc trop long non plus quoi.

Exemple :
```
- Nouvelle vue pour consulter la fiche d'un logement
- Ajout du composant MonSuperComposantQuiTue
```

Vous pouvez noter quand bas de la page vous pouvez voir les nouveautés que votre PR appotera à la branche develop.

Cliquez sur le bouton vert pour créer la PR :
```
Create pull request
```

### 5. Attendre la validation de la PR

Maintenant il faut attendre que quelqu'un valide votre PR, je pense qu'on va mettre 2 ou 3 personnes pour valider les PR.

L'objectif d'une validation est de vérifier que le code est propre et qu'il est commenté. C'est surtout ça le plus important.


### 6. Merge de la PR

Une fois que votre PR est validée, votre branche de travail de votre PR va être mergée dans la branche develop. Et paf votre code est dans le projet.