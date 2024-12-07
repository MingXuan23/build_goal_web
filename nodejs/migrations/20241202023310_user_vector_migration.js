/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('user_vector', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.json('values').nullable();
        table.boolean('status').defaultTo(true);
        table.bigInteger('user_id').unsigned().notNullable()
        .references('id').inTable('users').onDelete('CASCADE');
       
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();// Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('user_vector');
};
