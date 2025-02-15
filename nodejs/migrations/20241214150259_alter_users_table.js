/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('users', function(table) {
        table.boolean('is_gpt').defaultTo('false').alter();
        table.boolean('gpt_status').defaultTo('false').alter();
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function(knex) {
    // return knex.schema.table('users', function(table) {
    //     table.boolean('is_gpt').defaultTo('true');
    //     table.boolean('gpt_status').defaultTo('true');//rollback
    // });
  };
  