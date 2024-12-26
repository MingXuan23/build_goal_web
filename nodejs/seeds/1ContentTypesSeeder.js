/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */
exports.seed = async function(knex) {
  // Deletes ALL existing entries
  const contentTypes = [
    { id :1,type: 'Course and Training', desc: 'Educational programs and workshops' },
    { id :2,type: 'MicroLearning Resource', desc: 'Short, focused learning resources' },
    { id :3,type: 'Micro Entrepreneurship', desc: 'Resources and opportunities for small business' },
    { id :4,type: 'Job Offering', desc: 'Available job positions' },
    { id :5,type: 'Event', desc: 'Upcoming events and activities' },
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
