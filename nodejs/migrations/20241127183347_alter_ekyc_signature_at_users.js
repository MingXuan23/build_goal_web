/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('users', function(table) {
      table.string('ekyc_signature', 1000).alter(); // Modify the column size to 1000
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function(knex) {
    return knex.schema.table('users', function(table) {
      table.string('ekyc_signature', 255).alter(); // Revert back to 255 if rolled back
    });
  };
  