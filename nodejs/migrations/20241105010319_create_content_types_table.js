/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('content_types', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('type').notNullable(); // Type, required
        table.text('desc').nullable(); // Description, optional
        table.boolean('status').defaultTo(true); 
      });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('content_types');
};
