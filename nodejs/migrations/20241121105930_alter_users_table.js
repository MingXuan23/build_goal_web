/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.alterTable('users', function (table) {
    table.string('icNo').notNullable(); // ic number, required
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.alterTable('users', function (table) {
     //   table.dropColumn('icNo'); // Remove the column if rolled back
    });
    
};
