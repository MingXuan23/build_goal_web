/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */
exports.seed = async function(knex) {
  // Deletes ALL existing entries
  const applications = [
   {id:1,name: 'BuildGrowth-Mobile'},
   {id:2 ,name: 'BuildGoal-Web'},

  ];

  return Promise.all(
    applications.map(app => {
      return knex('application')
        .select('*')
        .where('name', app.name)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('application').insert(app);
          }
        });
    })
  );
};
