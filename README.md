## xBUG WEB v1.0.0
## xBUG API v1.0.0
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

For adding new migration 
```
knex migrate:make migration_name
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

## In Case to solve the laravel running slow


1. go to laravel\docker\php\php.ini
2. Modify the value of the opcache.validate_timestamps = 0 and run this command
  ```
   docker-compose restart laravel-app
   ```
3. This action will speed up your laravel project but any changes you made in the project will not update to the docker

4. To update your changes to the docker,  Modify the value of the opcache.validate_timestamps = 2 and run this command
   ```
   docker-compose restart laravel-app
   ```
5. This action will slow down a bit your laravel project but your changes will update to the docker
 
