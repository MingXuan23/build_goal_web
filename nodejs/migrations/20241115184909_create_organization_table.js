/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('organization', function (table) {
        table.bigIncrements('id').primary(); // Primary key
        table.string('name').notNullable(); // Name, required
        table.string('desc').nullable(); // Description, optional
        table.boolean('status').defaultTo(true); // Default status
        table.string('logo').nullable(); // Logo
        table.string('address').nullable(); // Address
        table.string('state').nullable(); // State
        table.string('email').nullable(); // Email
        table.string('org_type').nullable().index() // Add an index to `org_type`
            .references('type') // Set foreign key reference
            .inTable('organization_type') // Reference `organization_type`
            .onDelete('SET NULL'); // Handle delete
        table.string('payment_key').nullable(); // Payment key
        table.timestamps(true, true); // Created at & Updated at timestamps
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('organization');
};
