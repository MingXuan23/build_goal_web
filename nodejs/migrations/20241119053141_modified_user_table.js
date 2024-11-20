/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.alterTable('users', function (table) {
        table.string('email_status').nullable();
        table.string('verification_code').nullable();
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.alterTable('users', function (table) {
      table.dropColumn('email_status'); // Remove the column if rolled back
      table.dropColumn('verification_code');
    });
};
