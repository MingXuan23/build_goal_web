/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('gpt_table', function(table) {
        table.integer('max_token').alter();
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function(knex) {
    // return knex.schema.table('gpt_table', function(table) {
    //     table.string('max_token').nullable();
    // });
  };
  