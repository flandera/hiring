# Legacy hiring app
This example application reads users from mysql database and sends data to an external service via REST API.

## How to use
1) docker-compose up
2) import dump.sql to the database
3) cp .env.local .env
4) setup your variables in .env - DB conection, API url
5) run 'docker exec -it hiring php App.php send:clients' 