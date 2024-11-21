/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.alterTable('user_token', function (table) {
        table.timestamp('expired_at').nullable().alter(); // Change expired_at to timestamp and make it NOT NULL
        table.timestamp('updated_at').nullable();
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.alterTable('user_token', function (table) {
        table.datetime('expired_at').notNullable().alter(); // Revert expired_at to datetime and make it nullable
    });
};
