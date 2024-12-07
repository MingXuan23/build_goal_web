/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema.createTable('user_privacy', function (table) {
        table.bigIncrements('id').primary(); // Primary key, auto-incrementing ID
        table.bigInteger('user_id').unsigned().notNullable()
        .references('id').inTable('users').onDelete('CASCADE');
        table.json('detail').defaultTo({"useGPT":true,"useContent":true,"useBackup":false, "backUpFreq":"First Transaction In A Day"}); // Name, required
    });
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTableIfExists('user_privacy');
};