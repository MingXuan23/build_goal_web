/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('users', function(table) {
        table.string('ekyc_signature',255);
    });

};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.alterTable('contents', function (table) {
       // table.dropColumn('ekyc_signature'); // Remove the column if rolled back
    });
    
};