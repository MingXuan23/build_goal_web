/**
 * @param {import("knex").Knex} knex
 * @returns {Promise<void>}
 */
exports.seed = async function (knex) {
    // Deletes ALL existing entries in the package table
    await knex('package').del();
  
    // Inserts seed entries
    await knex('package').insert([
      {
        id: 1,
        estimate_user: 50,
        base_price: 100.00,
        name: 'Package A',
        base_state: 1,
        status: true
      },
      {
        id: 2,
        estimate_user: 100,
        base_price: 200.00,
        name: 'Package B',
        base_state: 1,
        status: true
      },
      {
        id: 3,
        estimate_user: 150,
        base_price: 300.00,
        name: 'Package C',
        base_state: 1,
        status: true
      },
      {
        id: 4,
        estimate_user: 200,
        base_price: 400.00,
        name: 'Package D',
        base_state: 1,
        status: true
      },
    ]);
  };
  