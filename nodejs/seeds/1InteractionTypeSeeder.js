/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.seed = async function (knex) {
  // Data to seed
  const interactionTypes = [
    {id :1, type: 'viewed', desc: 'The content was viewed by the user', status: true },
    { id :2,type: 'clicked', desc: 'The content was clicked by the user', status: true },
    { id :3,type: 'enrolled', desc: 'The user enrolled in the content', status: true },
  ];

  return Promise.all(
    interactionTypes.map(async (interaction) => {
      return knex('interaction_type')
        .select('*')
        .where('type', interaction.type)
        .first()
        .then((existing) => {
          if (!existing) {
            return knex('interaction_type').insert(interaction);
          }
        });
    })
  );
};
