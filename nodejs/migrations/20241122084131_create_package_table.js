/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('package', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.bigInteger('estimate_user').nullable(); 
        table.decimal('base_price',12,2).nullable();
        table.string("name").notNullable(); // package name
        table.integer('base_state').defaultTo(1); // Base state, defaults to 1
        table.boolean('status').defaultTo(true) //status as boolean, default to true
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('package');
};
