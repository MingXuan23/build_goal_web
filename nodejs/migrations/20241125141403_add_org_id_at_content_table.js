/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.table('content_promotion', function (table) {
        
        table.boolean('completed').defaultTo('false');

    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.table('contents', function(table) {
     // table.dropColumn('user_id'); // Foreign key to users table

        
    });
};