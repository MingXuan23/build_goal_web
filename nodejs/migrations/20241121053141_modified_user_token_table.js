/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.alterTable('user_token', function (table) {
        table.string('token').nullable();
        table.string('remember_token').nullable();
        table.string('device_token').nullable();

    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.alterTable('users', function (table) {
      table.dropColumn('token'); // Remove the column if rolled back
      table.dropColumn('remember_token');
      table.dropColumn('device_token');

    });
};
