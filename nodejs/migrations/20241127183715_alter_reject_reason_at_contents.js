/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('contents', function(table) {
      table.string('reject_reason').nullable().alter(); // Modify the column size to 1000
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function(knex) {
    return knex.schema.table('contents', function(table) {
     //table.string('reject_reason').notNullable.alter(); // Revert back to 255 if rolled back
    });
  };
  