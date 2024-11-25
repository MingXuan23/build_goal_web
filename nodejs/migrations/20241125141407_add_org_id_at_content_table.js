/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.table('contents', function (table) {
        
        table.bigInteger('user_id').unsigned().nullable()
            .references('id').inTable('users').onDelete('CASCADE'); // Foreign key to users table

    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.table('contents', function(table) {
      table.bigInteger('user_id').unsigned().nullable()
       .references('id').inTable('users').onDelete('CASCADE'); // Foreign key to users table

        
    });
};