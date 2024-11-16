/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('application', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('name').notNullable(); // Name, required
    });
  
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('application');
};
