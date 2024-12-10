/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('thumbnails', function (table) {
        table.bigIncrements('id').primary(); // Auto-incrementing ID
        table.string('url').notNullable(); // URL of the thumbnail image
        table.timestamps(true, true); // Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTableIfExists('thumbnails');
};
