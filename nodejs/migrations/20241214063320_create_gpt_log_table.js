/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('gpt_log', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('name').notNullable(); // log name, not optional
        table.string('model').notNullable(); // model name, not optional
        table.string('provider').notNullable(); // provider name, not optional
        table.bigInteger('user_id').unsigned().nullable()
        .references('id').inTable('users').onDelete('CASCADE'); // Foreign key to users table
        table.boolean('status').defaultTo('true');
        table.string('request').nullable(); // request name, optional
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();// Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTableIfExists('gpt_table');
};
