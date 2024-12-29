/**
 * @param {import("knex").Knex} knex
 * @returns {Promise<void>}
 */
exports.seed = async function (knex) {

  // Inserts new entries
  const roles = [
    { id:1,role: 'admin', desc: 'Administrator roles' },
    { id:2, role: 'organization', desc: 'organization role' },
    { id:3, role:  'content-creator', desc: 'Content creator role' },
    { id:5, role: 'mobile user', desc: 'Mobile user role' },
  ];

  return Promise.all(
    roles.map(role => {
      return knex('roles')
        .select('*')
        .where('role', role.role)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('roles').insert(role);
          }
        });
    })
  );
};
