// Update with your config settings.

/**
 * @type { Object.<string, import("knex").Knex.Config> }
 */

require('dotenv').config(); 

module.exports = {

  development: {
    client: 'mysql2',
    connection: {
      host: process.env.LOCAL_DB_HOST,
      port: process.env.LOCAL_DB_PORT,
      user: process.env.LOCAL_DB_USER,
      password: process.env.LOCAL_DB_PASSWORD,
      database: process.env.LOCAL_DB_NAME,

    },
    migrations: {
      directory: './migrations'
    }
  },

  docker: {
    client: 'mysql2',
    connection: {
      host: 'build_goal_web-mysql-1',
      port: 3306,
      user: process.env.LOCAL_DB_USER,
      password: process.env.LOCAL_DB_PASSWORD,
      database: process.env.LOCAL_DB_NAME,
   
    },
    migrations: {
      directory: './migrations'
    }
  },

  production: {
    client: 'mysql2',
    connection: {
      host: 'build_goal_web-mysql-1',
      port: 3306,
      user: process.env.LOCAL_DB_USER,
      password: process.env.LOCAL_DB_PASSWORD,
      database: process.env.LOCAL_DB_NAME,
    },
    migrations: {
      directory: './migrations'
    }
  }

};
