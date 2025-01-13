/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('financial_advice', function(table) {
        table.bigIncrements('id').primary();
         table.string('name').nullable();
          table.longtext('desc').nullable(); // JSON column for details
          
               table.boolean('status').defaultTo(true).nullable();
        });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('financial_advice');
};
