/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.table('contents', function (table) {
        
        table.bigInteger('org_id').unsigned().nullable()
            .references('id').inTable('organization').onDelete('CASCADE'); // Foreign key to users table

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