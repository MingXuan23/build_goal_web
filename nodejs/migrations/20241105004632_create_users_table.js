/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('users', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing
        table.string('name').notNullable(); // Name, required
        table.string('password').notNullable(); // Password, required (hashed)
        table.string('telno'); // Telephone number
        table.string('address').nullable(); // Address, nullable
        table.string('state').nullable(); // State, nullable
        table.string('email').nullable(); // Email, nullable
        table.string('status').nullable(); // Status, nullable
        table.json('role').nullable(); // Role, nullable, stored as JSON [1,2]
        table.boolean('active').defaultTo(true); // Active status, defaults to true
        table.timestamps(true, true); // Created at & Updated at timestamps
      });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('users');
};
