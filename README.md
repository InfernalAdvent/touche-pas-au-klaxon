# Touche pas au klaxon

Application web permettant de diffuser au sein de l'entreprise les trajets prévus afin de favoriser le covoiturage

## Prérequis

XAMPP (ou MAMP/WAMP selon votre OS), pour avoir l'accès à PHP et MySQL.
Git pour cloner le dépôt.

### 1. Cloner le dépôt

```bash
git clone https://github.com/InfernalAdvent/touche-pas-au-klaxon.git
cd touche-pas-au-klaxon
```

Placez le dossier du projet dans C:\xampp\htdocs

### 2. Configuration de la base de données

Créez une base de données MySQL (`touche_pas_au_klaxon` par exemple)
Importez les scripts suivants :
- `database.sql`
- `data.sql`

### 3. Lancez le serveur

Lancez Apache et MySQL via XAMPP, puis allez sur l'URL http://localhost/touche-pas-au-klaxon/public

### 4. Réaliser les tests PHPUnit

Pour réaliser les tests unitaires, il faut créer la base de données `phpunit_test` et y entrer la table users au minimum (le script de création se trouve dans `database.sql`).

Une fois que c'est fait, il ne reste plus qu'à lancer dans le terminal :

```bash
vendor\bin\phpunit --colors=auto tests
```





