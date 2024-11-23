/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */
exports.seed = async function(knex) {


  const contents = [
    {
      name: 'Microentrepreneuship:start with roti canai',
      desc: 'Learn how to start a successful roti canai business',
      link: null,
      content: "```***Introduction***Here I will teach u do make roti canai```***Sell it!***Find your neighbour and sell to them",
      enrollment_price: '0.00',
      status: 1,
      category_weight: null,
      content_type_id: await knex('content_types')
        .where('type', 'MicroLearning Resource')
        .select('id')
        .first()
        .then(result => result.id),
      place: null,
      participant_limit: null,
      state: null,
      created_at: knex.fn.now(),
      updated_at: knex.fn.now(),
      closed_at: null,
      reason_phrase: 'APPROVED',
      first_date: null
    },
    {
      name: 'Online Course: Flutter Helper Course',
      desc: 'Comprehensive course on Flutter development',
      link: null,
      content: null,
      enrollment_price: 10.00,
      status: 1,
      category_weight: null,
      content_type_id: await knex('content_types')
        .where('type', 'Course and Training')
        .select('id')
        .first()
        .then(result => result.id),
      place: 'Recap Room, FTMK, UTeM',
      participant_limit: 100,
      state: JSON.stringify(['Melaka']),
      created_at: knex.fn.now(),
      updated_at: knex.fn.now(),
      closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
      reason_phrase: 'APPROVED',
      first_date: new Date('2025-01-02').toISOString().slice(0, 19).replace('T', ' ')
    },
    {
      name: 'Event: Satria Car Boot Sale',
      desc: 'Community car boot sale event',
      link: null,
      content: null,
      enrollment_price: 20.00,
      status: 1,
      category_weight: null,
      content_type_id: await knex('content_types')
        .where('type', 'Micro Entrepreneurship')
        .select('id')
        .first()
        .then(result => result.id),
      place: 'Satria Cafe, UTeM',
      participant_limit: 20,
      state: JSON.stringify(['Melaka']),
      created_at: knex.fn.now(),
      updated_at: knex.fn.now(),
      closed_at: new Date('2025-01-01').toISOString().slice(0, 19).replace('T', ' '),
      reason_phrase: 'APPROVED',
      first_date: new Date('2025-01-05').toISOString().slice(0, 19).replace('T', ' ')
    }
  ];

  return Promise.all(
    contents.map(content => {
      return knex('contents')
        .select('*')
        .where('name', content.name)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('contents').insert(content);
          }
        });
    })
  );
};