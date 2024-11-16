/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('roles', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('role').notNullable().unique(); // Role name, required and unique
        table.string('desc').nullable(); // Description, optional
        table.timestamps(true, true); // Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTableIfExists('roles');
};
