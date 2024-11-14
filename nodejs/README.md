## Prerequisites

get the docker at here https://docs.docker.com/get-docker/

## Getting Started

1. Clone this repository and copy .env file into project

2. Build and run the Docker container in development mode

   ```
   docker-compose up --build
   ```


   This will start the server on `http://localhost:3000` with hot-reloading enabled.
3. If you are facing cannot connect to database using password yes


Open MySQL Workbench in your PC, try the connection using the configuration that u set up in the .env file. After connecting to the Workbench, you should able to access the database using phpmyadmin in port 8006



4. Database Migration and Seeder

```
npx knex migrate:latest --env development
```
```
npx knex seed:run --env development
```

   
## In Case need to remove the docker and rebuild it again from the begining


1. Run these two command:
   ```
   docker-compose down -v
   docker-compose up -d
   ```
