const { nullable } = require("zod");

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.table('content_card', function (table) {
    
      table.string('verification_code').nullable(); // String, nullable
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function (knex) {
    //return knex.schema.dropTableIfExists('content_card'); // Drop the table on rollback
  };
  