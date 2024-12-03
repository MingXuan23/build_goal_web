/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */

const xlsx = require('xlsx');

exports.seed = async function(knex) {
  // Deletes ALL existing entries
 let id = 1;

  const workbook = xlsx.readFile('./seeds/result.xlsx'); // Adjust the path
  const sheetName = workbook.SheetNames[0]; // Use the first sheet
  const sheetData = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);

  // Format data for insertion
  const data = sheetData.map(row => ({
      id: id++,
      name: row['Label'], // Map Excel columns to DB columns
      values: JSON.stringify([
        row['Education and Self Improvement'],
        row['Entertainment and Health Fitness'],
        row['Financial and business'],
        row['Technology and digital'],
        row['fashion and art'],
        row['production and construction'],
        row['transportationa and logistics'],
        row['social and personal services']
    ])
   
      // Add more mappings as needed
  }));


  return Promise.all(
    data.map(d => {
      return knex('labels')
        .select('*')
        .where('name', d.name)
        .first()
        .then(existing => {
          if (!existing) {
            return knex('labels').insert(d);
          }
        });
    })
  );
};
