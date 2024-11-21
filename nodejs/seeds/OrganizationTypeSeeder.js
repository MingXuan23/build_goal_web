/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.seed = async function (knex) {
  // Deletes ALL existing entries
  await knex('organization_type').del();

  // Inserts seed entries
  await knex('organization_type').insert([
      { type: 'Government', desc: 'Government-related organizations' },
      { type: 'Company', desc: 'Private companies and enterprises' },
      { type: 'Skill Training Vendor', desc: 'Organizations providing skill training services' },
      { type: 'NGO', desc: 'Non-governmental organizations' },
      { type: 'Content Creator', desc: 'Individuals or teams creating digital content' },
      { type: 'Event Organizer', desc: 'Organizations planning and executing events' }
  ]);
};
