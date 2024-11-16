/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('user_token', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.bigInteger('user_id').unsigned().references('id').inTable('users').onDelete('CASCADE');
        table.datetime('created_at').nullable(); // Created at, optional
        table.datetime('expired_at').nullable(); // Expired at, optional
        table.bigInteger('app_id').unsigned().references('id').inTable('application').onDelete('CASCADE');
        table.string('desc').nullable(); // Description, optional
        table.boolean('status').defaultTo(true); // Status as boolean, defaults to true
        table.string('ip_address').nullable(); // IP address, optional

    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('user_token');
};
