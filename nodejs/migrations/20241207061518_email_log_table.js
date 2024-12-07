/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('email_logs', (table) => {
      table.increments('id').primary();
      table.string('email_type').notNullable();
      table.string('recipient_email').notNullable();
      table.string('from_email').notNullable();
      table.string('name').notNullable();
      table.string('status').notNullable();
      table.string('response_data').notNullable();
      table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
      table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();
    });
  };

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
  
};
