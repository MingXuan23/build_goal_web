/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('email_status', function(table) {
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();// Created at & Updated at timestamps
    });

};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    // return knex.schema.table('email_status', function(table) {
    //     table.dropColumn('created_at');
    //     table.dropColumn('updated_at');

    // });
};