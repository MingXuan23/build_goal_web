/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('leaf_detail', function(table) {
    table.bigIncrements('id').primary();
      table.bigInteger('user_leaf_id').unsigned().notNullable()
           .references('id').inTable('user_leaf').onDelete('CASCADE'); // Foreign key to user_leaf table
      table.json('detail').nullable(); // JSON column for details
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
    return knex.schema.dropTableIfExists('leaf_detail');
  };
  
