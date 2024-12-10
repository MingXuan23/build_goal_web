/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('organization_user', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.bigInteger('user_id').unsigned().notNullable()
            .references('id').inTable('users').onDelete('CASCADE'); // Foreign key to users table
        table.bigInteger('organization_id').unsigned().notNullable()
            .references('id').inTable('organization').onDelete('CASCADE'); // Foreign key to organization table
        table.bigInteger('role_id').unsigned().notNullable()
            .references('id').inTable('roles').onDelete('CASCADE'); // Foreign key to roles table
        table.boolean('status').defaultTo(true); // Status, defaults to true
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();// Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTableIfExists('organization_user');
};
