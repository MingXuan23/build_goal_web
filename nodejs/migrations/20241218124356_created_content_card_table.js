const { nullable } = require("zod");

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('content_card', function (table) {
      table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
  
      table.string('card_id').nullable(); // String, nullable
      table.boolean('status').defaultTo(true).nullable(); // Boolean, default true, nullable
      table.timestamp('startdate').nullable(); // Timestamp, nullable
      table.timestamp('enddate').nullable(); // Timestamp, nullable
  
      table.bigInteger('transaction_id') // Foreign key to 'transaction' table
           .unsigned()
           .references('id')
           .inTable('transactions')
           .onDelete('SET NULL') // Optional: handle cascading delete
           .nullable();
  
      table.string('tracking_id').nullable(); // String, nullable
  
      table.timestamp('created_at').defaultTo(knex.fn.now()).nullable(); // Created at timestamp
      table.timestamp('updated_at')
           .defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
           .nullable(); // Updated at timestamp
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function (knex) {
    return knex.schema.dropTableIfExists('content_card'); // Drop the table on rollback
  };
  