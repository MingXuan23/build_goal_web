/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable('user_password_reset', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing
        table.string('unique_id').notNullable(); // Name, required
        table.boolean('status').nullable();
        table.timestamps(true, true); // Created at & Updated at timestamps
        table.timestamp('expired_at').nullable();
        table.bigInteger('user_id').unsigned().notNullable()
            .references('id').inTable('users').onDelete('CASCADE'); // Foreign key to users table

    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function (knex) {
    return knex.schema.dropTableIfExists('user_password_reset');
};
