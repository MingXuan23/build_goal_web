// /**
//  * @param { import("knex").Knex } knex
//  * @returns { Promise<void> }
//  */
// exports.up = async function (knex) {
//     const hasRoleColumn = await knex.schema.hasColumn('users', 'role');

//     return knex.schema.alterTable('users', function (table) {
//         if (!hasRoleColumn) {
//             table.json('role').nullable(); // Add 'role' column only if it doesn't exist
//         }
//         table.dropForeign('role_id'); // Drop foreign key constraint on 'role_id'
//         table.dropColumn('role_id');  // Drop 'role_id' column
//     });
// };

// /**
//  * @param { import("knex").Knex } knex
//  * @returns { Promise<void> }
//  */
// exports.down = function (knex) {
//     return knex.schema.alterTable('users', function (table) {
//         table.dropColumn('role'); // Remove 'role' column
//         table.bigInteger('role_id').unsigned().references('id').inTable('roles').onDelete('CASCADE'); // Add back 'role_id' column
//     });
// };

