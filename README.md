## Dashboard-Quality

# Initiation du projet
1. Créer le fichier du Projet .env à partir du .env.model à la racine du projet
2. Créer son fichier du répertoire back .env à partir du .env.model dans /back
3. Lancer la commande
`docker-compose up -d`
4. Entrez dans le container php-cli `docker exec -it quality_php-cli bash`
5. Installez les vendor `composer install`
6. Exécutez les migrations d'initialisation du projet `php bin/console doctrine:migration:migrate --no-interaction`
7. Quittez le container back puis en local Lancez la commande `cd front & npm install` (si besoin mettez à jour npm sur votre environnement local)
8. Exécutez la commande `yarn start` afin de lancer le front du projet 
