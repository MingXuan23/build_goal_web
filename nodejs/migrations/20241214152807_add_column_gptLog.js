/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.table('gpt_log', function(table) {
        table.string('prompt_tokens').nullable();
        table.string('completion_tokens').nullable();
        table.string('total_tokens').nullable();
    });

};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.table('gpt_log', function(table) {
        table.dropColumn('prompt_tokens');
        table.dropColumn('completion_tokens');
        table.dropColumn('total_tokens');
    });
};