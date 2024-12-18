/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('user_content', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
    
        table.bigInteger('user_id') // Foreign key to user table
             .unsigned()
             .references('id')
             .inTable('users')
             .onDelete('CASCADE')
             .notNullable();
    
        table.bigInteger('interaction_type_id') // Foreign key to interaction_type table
             .unsigned()
             .references('id')
             .inTable('interaction_type')
             .onDelete('SET NULL')
             .nullable();
    
        table.boolean('status').defaultTo(true).nullable(); // Status, default true, nullable
    
        table.bigInteger('content_id') // Foreign key to content table
             .unsigned()
             .references('id')
             .inTable('contents')
             .onDelete('CASCADE')
             .nullable();
    
        table.string('ip_address').nullable(); // IP address, nullable
        table.string('token').nullable(); // Token, nullable
        table.string('verification_code').nullable(); // Verification code, nullable
        table.string('desc').nullable(); // Description field, nullable
        table.json('information').nullable(); // Information field, JSON type, nullable
    
        table.timestamp('created_at').defaultTo(knex.fn.now()).nullable();
        table.timestamp('updated_at')
             .defaultTo(knex.raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
             .nullable();
      });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
  
};
