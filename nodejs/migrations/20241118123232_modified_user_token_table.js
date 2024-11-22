/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = async function (knex) {
    return knex.schema.alterTable('user_token', async function (table) {
        table.timestamp('expired_at').nullable().alter(); // Change expired_at to timestamp and make it nullable

        const hasUpdatedAt = await knex.schema.hasColumn('user_token', 'updated_at');
        if (!hasUpdatedAt) {
            table.timestamp('updated_at').nullable(); // Add updated_at only if it doesn't exist
        }
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.alterTable('user_token', function (table) {
        table.datetime('expired_at').notNullable().alter(); // Revert expired_at to datetime and make it not nullable
        // No need to remove the updated_at column in down migration since it might have existed before
    });
};
