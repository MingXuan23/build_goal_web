/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('content_label', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.bigInteger('content_id').unsigned().notNullable()
            .references('id').inTable('contents').onDelete('CASCADE'); // Foreign key to users table
        table.bigInteger('label_id').unsigned().notNullable()
            .references('id').inTable('labels').onDelete('CASCADE'); // Foreign key to organization table
      
          
            table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
      table.timestamp('updated_at').defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')).nullable();
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('content_label');
};
