/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.seed = async function (knex) {

  // Inserts seed entries
  const org_types =  [
      { id:1, type: 'Government', desc: 'Government-related organizations' },
      { id:2, type: 'Company', desc: 'Private companies and enterprises' },
      { id:3, type: 'Skill Training Vendor', desc: 'Organizations providing skill training services' },
      { id:4, type: 'NGO', desc: 'Non-governmental organizations' },
      { id:5, type: 'Content Creator', desc: 'Individuals or teams creating digital content' },
      { id:6, type: 'Event Organizer', desc: 'Organizations planning and executing events' }
  ];

  return Promise.all(
    org_types.map(type => {
      return knex('organization_type')
        .select('*')
        .where('type', type.type)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('organization_type').insert(type);
          }
        });
    })
  );
};
