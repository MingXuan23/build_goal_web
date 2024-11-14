/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('contents', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.string('name').notNullable(); // Name, required
        table.string('desc').nullable(); // Description, optional
        table.string('link').nullable(); // Link, optional
        table.longtext('content').nullable(); // Content, optional
        table.decimal('enrollment_price', 10, 2).defaultTo(0); // Enrollment price, defaults to 0
        table.boolean('status').defaultTo(true); // Status as boolean, defaults to true
        table.json('category_weight').nullable(); // Category weight, optional// Created at, optional
        // Closed at, optional
        table.bigInteger('content_type_id').unsigned().references('id').inTable('content_types').onDelete('CASCADE');
        table.bigInteger('edit_from').unsigned().references('id').inTable('contents').onDelete('CASCADE'); // Edit history, optional
        table.string('place').nullable(); // Place, optional
        table.bigInteger('participant_limit').nullable(); // Participant limit, optional
        table.json('state').nullable(); // State, optional
        table.timestamps(true, true); 
        table.datetime('closed_at').nullable(); // Automatically add created_at and updated_at timestamps
      });
};


/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
  
};
