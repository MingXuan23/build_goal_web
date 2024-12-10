/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('transactions', function (table) {
      table.bigIncrements('id').primary(); // Primary key, auto-incrementing
      table.bigInteger('user_id').unsigned().nullable().references('id').inTable('users').onDelete('SET NULL'); // Foreign key to users table, nullable
      table.bigInteger('organization_id').unsigned().nullable().references('id').inTable('organization').onDelete('CASCADE'); // Foreign key to organizations table, nullable
      
      table.string('status').nullable(); // Status, nullable
      table.string('sellerOrderNo').nullable(); // Seller order number, nullable
      table.string('transac_no').nullable(); // Transaction number, nullable
      table.decimal('amount', 10, 2).nullable(); // Amount, with 2 decimal places, nullable
      
      table.string('sellerExOrderNo').nullable(); // Seller external order number, nullable
      table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
      table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();// Created at & Updated at timestamps
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function(knex) {
    return knex.schema.dropTableIfExists('transactions');
  };
  