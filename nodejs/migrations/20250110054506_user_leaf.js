/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('user_leaf', function(table) {
      table.bigIncrements('id').primary();
      table.bigInteger('user_id').unsigned().references('id').inTable('users').onDelete('CASCADE');
      table.integer('total_leaf').defaultTo(0); // Total leaf count
      table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
      table.timestamp('updated_at')
           .defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
           .nullable();
           table.boolean('status').defaultTo(true).nullable();
    });
  };
  


/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('user_leaf');
  };
