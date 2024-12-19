const { nullable } = require("zod");

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.table('content_card', function (table) {
    
      table.bigInteger('content_id') // Foreign key to 'transaction' table
           .unsigned()
           .references('id')
           .inTable('contents')
           .onDelete('CASCADE') // Optional: handle cascading delete
           .nullable();

    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function (knex) {
    //return knex.schema.dropTableIfExists('content_card'); // Drop the table on rollback
  };
  