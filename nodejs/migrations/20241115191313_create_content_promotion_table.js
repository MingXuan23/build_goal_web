/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('content_promotion', function (table) {
      table.bigIncrements('id').primary(); // Primary key, auto-incrementing
      table.bigInteger('content_id').unsigned().notNullable().references('id').inTable('contents').onDelete('CASCADE'); // Foreign key to contents table, bigInteger
  
      table.decimal('views', 10, 2).defaultTo(0); // Views, default 0
      table.decimal('clicks', 10, 2).defaultTo(0); // Clicks, default 0
      table.decimal('enrollment', 10, 2).defaultTo(0); // Enrollment, default 0
      table.decimal('comments', 10, 2).defaultTo(0); // Comments, default 0
      table.json('target_audience').nullable(); // Target audience as JSON, nullable
      table.decimal('estimate_reach', 10, 2).defaultTo(0); // Estimated reach, default 0
      table.decimal('promotion_price', 10, 2).defaultTo(0); // Promotion price, default 0
      table.boolean('status').defaultTo(true); // Status, default true
      table.timestamps(true, true); // Created at & Updated at timestamps
      table.bigInteger('transaction_id').unsigned().nullable().references('id').inTable('transactions').onDelete('CASCADE'); // Foreign key to transactions table, nullable
    });
  };
  
  /**
   * @param { import("knex").Knex } knex
   * @returns { Promise<void> }
   */
  exports.down = function(knex) {
    return knex.schema.dropTableIfExists('content_promotion');
  };
  