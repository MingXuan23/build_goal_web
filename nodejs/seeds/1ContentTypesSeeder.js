/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */
exports.seed = async function(knex) {
  // Deletes ALL existing entries
  const contentTypes = [
    { type: 'Course and Training', desc: 'Educational programs and workshops' },
    { type: 'MicroLearning Resource', desc: 'Short, focused learning resources' },
    { type: 'Micro Entrepreneurship', desc: 'Resources and opportunities for small business' },
    { type: 'Job Offering', desc: 'Available job positions' },
    { type: 'Event', desc: 'Upcoming events and activities' },
  ];

  return Promise.all(
    contentTypes.map(contentType => {
      return knex('content_types')
        .select('*')
        .where('type', contentType.type)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('content_types').insert(contentType);
          }
        });
    })
  );
};
