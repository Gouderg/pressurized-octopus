# pressurized-octopus



## Mise en place du front 
Il faut se placer dans le répetoire front et faire un npm i.

Ensuite, on peut changer l'url de l'API dans le fichier src/Components/global.js


## Installer la base de donnée:

Il faut tout d'abord ouvrir la console de mysql et faire un ``` source config/generate_database/bdd.sql```.

Ensuite, il faut se rendre à la racine du projet et faire un ``` bin:console doctrine:migrations:migrate ```.

Enfin, il faut retourner dans la console mysql et taper la commande ``` source config/generate_database/insertData.sql ```.

## URL

#### CRUD

| Nom | Path |
|:---:|:----:|
| Login | / |
| Homepage | /hompage |
| TablePlonge - Show | /table/show |
| TablePlonge - Create | /table/create |
| TablePlonge - Delete | /table/delete/{id} |
| TablePlonge - Edit | /table/edit{id} |
| Profondeur - Show | /profondeur/show |
| Profondeur - Create | /profondeur/create |
| Profondeur - Delete | /profondeur/delete/{id} |
| Profondeur - Edit | /profondeur/edit{id} |
| Temps - Show | /temps/show |
| Temps - Create | /temps/create |
| Temps - Delete | /temps/delete/{id} |
| Temps - Edit | /temps/edit{id} |


#### API

Utilisation avec une méthode **GET**

| Nom | Path |
|:---:|:----:|
| Récupère une table de plongée | /api/tables/{id} |
| Calcule et renvoie des données de plongée | /api/calc |

#### FRONT

| Nom | Path |
|:---:|:----:|
| Homepage | / |
| Formulaire | /calculform |
| Affichage des tables de plongée| /table |


