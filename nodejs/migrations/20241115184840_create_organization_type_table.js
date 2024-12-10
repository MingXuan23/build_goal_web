/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('organization_type', function (table) {
        table.bigIncrements('id').primary(); // Primary key
        table.string('type').notNullable().unique(); // Ensure `type` is unique for FK references
        table.string('desc').nullable(); // Optional description
        table.boolean('status').defaultTo(true); // Default status
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();// Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('organization_type');
};
