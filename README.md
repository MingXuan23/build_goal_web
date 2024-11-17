## Prerequisites

get the docker at here https://docs.docker.com/get-docker/

## Getting Started

1. Clone this repository and copy .env file into project, u need to copy the final .env into ndoejs folder also

2. Build and run the Docker container in development mode

   ```
   docker-compose up --build
   ```


   This will start the server, nodejs and laravel. If you facing 502 bad gateway when open laravel web, please wait because the initailization did not completed yet

3. If you are facing cannot connect to database using password yes


Open MySQL Workbench in your PC, try the connection using the configuration that u set up in the .env file. After connecting to the Workbench, you should able to access the database using phpmyadmin in port 8006



4. Database Migration and Seeder (execute in exec tab in image node js)

```
npx knex migrate:latest --env docker
```
```
npx knex seed:run --env docker
```


5. Laravel Setup (execute in exec tab in image laravel app)

```
php artisan key:generate

php artisan optimize 
```
   
## In Case need to remove the docker and rebuild it again from the begining


1. Run these two command:
   ```
   docker-compose down -v
   docker-compose up -d
   ```
