/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */
exports.seed = async function(knex) {
  // Deletes ALL existing entries
  const states = [
    // Peninsular Malaysia States
    { name: "Johor" },
    { name: "Kedah" },
    { name: "Kelantan" },
    { name: "Kuala Lumpur" },
    { name: "Labuan" },
    { name: "Melaka" },
    { name: "Negeri Sembilan" },
    { name: "Pahang" },
    { name: "Perak" },
    { name: "Perlis" },
    { name: "Penang" },
    { name: "Putrajaya" },
    { name: "Selangor" },
    { name: "Terengganu" },
  
    // Sarawak Divisions
    { name: "Sarawak - Kuching" },
    { name: "Sarawak - Sri Aman" },
    { name: "Sarawak - Sibu" },
    { name: "Sarawak - Miri" },
    { name: "Sarawak - Limbang" },
    { name: "Sarawak - Sarikei" },
    { name: "Sarawak - Kapit" },
    { name: "Sarawak - Samarahan" },
    { name: "Sarawak - Bintulu" },
    { name: "Sarawak - Betong" },
    { name: "Sarawak - Mukah" },
    { name: "Sarawak - Serian" },
  
    // Sabah Divisions
    { name: "Sabah - Beaufort" },
    { name: "Sabah - Keningau" },
    { name: "Sabah - Kuala Penyu" },
    { name: "Sabah - Membakut" },
    { name: "Sabah - Nabawan" },
    { name: "Sabah - Sipitang" },
    { name: "Sabah - Tambunan" },
    { name: "Sabah - Tenom" },
    { name: "Sabah - Kota Marudu" },
    { name: "Sabah - Pitas" },
    { name: "Sabah - Beluran" },
    { name: "Sabah - Kinabatangan" },
    { name: "Sabah - Sandakan" },
    { name: "Sabah - Telupid" },
    { name: "Sabah - Tongod" },
    { name: "Sabah - Kalabakan" },
    { name: "Sabah - Kunak" },
    { name: "Sabah - Lahad Datu" },
    { name: "Sabah - Semporna" },
    { name: "Sabah - Tawau" },
    { name: "Sabah - Kota Belud" },
    { name: "Sabah - Kota Kinabalu" },
    { name: "Sabah - Papar" },
    { name: "Sabah - Penampang" },
    { name: "Sabah - Putatan" },
    { name: "Sabah - Ranau" },
    { name: "Sabah - Tuaran" },
  ];
  

  return Promise.all(
    states.map(state => {
      return knex('states')
        .select('*')
        .where('name', state.name)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('states').insert(state);
          }
        });
    })
  );
};
