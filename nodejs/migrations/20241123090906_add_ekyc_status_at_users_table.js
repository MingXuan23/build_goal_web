/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('users', function(table) {
        // Add the 'ekyc_status' column only if it doesn't already exist
        knex.schema.hasColumn('users', 'ekyc_status').then(exists => {
            if (!exists) {
                table.boolean('ekyc_status').defaultTo(true); // Add `ekyc_status` column
            }
        });

      
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.table('users', function(table) {
        table.dropColumn('ekyc_status'); // Remove `ekyc_status` column
        
    });
};
