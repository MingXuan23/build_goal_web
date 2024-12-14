/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('gpt_table', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('model_name').nullable(); // Description, optional
        table.string('provider').nullable(); // Description, optional
        table.boolean('status').defaultTo('true');
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTableIfExists('gpt_table');
};
