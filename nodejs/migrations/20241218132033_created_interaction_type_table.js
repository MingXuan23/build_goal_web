/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('interaction_type', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('type').notNullable(); // Type field, not nullable
        table.string('desc').nullable(); // Description field, nullable
        table.boolean('status').defaultTo(true).nullable(); // Status field, default true, nullable
    
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at')
             .defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
             .nullable();
      });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('interaction_type');
};
