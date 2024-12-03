/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('labels', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('name');
        table.boolean('status').defaultTo(true);

        table.json('values').nullable();
        table.timestamps(true, true); // Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('labels');
};
