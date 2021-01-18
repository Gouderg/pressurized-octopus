# pressurized-octopus

Enlever le node_modules et faire un npm i 

## Mise en place du front 
Il faut se placer dans le répetoire front et faire un npm i
Ensuite, on peut changer l'url de l'API dans le fichier src/Components/global.js


## Installer la base de donnée:

Il faut tout d'abord ouvrir la console de mysql et faire un ``` source config/generate_database/bdd.sql```.
Ensuite, il faut se rendre à la racine du projet et faire un ``` bin:console doctrine:migrations:migrate ```.
Enfin, il faut retourner dans la console mysql et taper la commande ``` source config/generate_database/insertData.sql ```.

