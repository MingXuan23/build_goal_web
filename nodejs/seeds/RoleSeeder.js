/**
 * @param {import("knex").Knex} knex
 * @returns {Promise<void>}
 */
exports.seed = async function (knex) {
  // Deletes ALL existing entries in the roles table
  await knex('roles').del();

  // Inserts new entries
  await knex('roles').insert([
    { role: 'admin', desc: 'Administrator role' },
    { role: 'staff', desc: 'Staff member role' },
    { role: 'organization', desc: 'organization role' },
    { role: 'content creator', desc: 'Content creator role' },
    { role: 'mobile user', desc: 'Mobile user role' },
  ]);
};
