/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> } 
 */

const bcrypt = require("bcrypt");

exports.seed = async function (knex) {
  // Clear existing entries (optional, depending on your requirement)
  //await knex('users').del();

  // Predefined user data
  const names = [
    'aaron', 'adam', 'alex', 'andrew', 'barbara', 'bella', 'blake', 'bob', 'brad', 'carla',
    'chloe', 'claire', 'colin', 'daisy', 'daniel', 'david', 'ella', 'elle', 'emma', 'evan',
    'evan', 'fernando', 'fay', 'flora', 'frank', 'gavin', 'gina', 'grace', 'grady', 'hayley',
    'helen', 'hannah', 'ian', 'ivy', 'jack', 'jackson', 'james', 'jason', 'javier', 'julia',
    'julian', 'kate', 'kevin', 'kelsey', 'karl', 'laura', 'lisa', 'luke', 'mara', 'matt',
    'mike', 'molly', 'nancy', 'nathan', 'nina', 'olga', 'oliver', 'pauline', 'peter', 'quinn',
    'quincy', 'rachel', 'rita', 'rose', 'ryan', 'samuel', 'sara', 'sophie', 'steve', 'tina',
    'tom', 'toby', 'troy', 'ursula', 'uriel', 'vance', 'victor', 'violet', 'walt', 'wendy',
    'william', 'wilson', 'xander', 'xena', 'yara', 'yasmine', 'zoe', 'zoey', 'zane', 'zara',
    'abby', 'brian', 'cathy', 'drew', 'ellen', 'finn', 'george', 'hugo', 'irene', 'jayden',
    'katie', 'leo', 'marco', 'nick', 'olivia', 'pat', 'rachel', 'susan', 'tommy', 'violetta'
];

const normalNames = [...new Set(names)].sort();
  
  
  const password = 'abc123';
  const hashedPassword = await bcrypt.hash(password, 10);

  // Possible roles
  const roles = [2,3,4];

  // Generate user data dynamically
  const users = normalNames.map((name, index) => ({
    name: `user_${name}`,
    password: hashedPassword,
    telno: `+6011222334${index}`,            // Example telephone numbers
    address: `${name.charAt(0).toUpperCase() + name.slice(1)}'s Address`, // Example address
    email: `${name}@xbug.online`,            // Example email
    status: 'ACTIVE',
    state: null,
    role: JSON.stringify([roles[Math.min(index, 3)]]), // Random role from 2-4
    created_at: knex.fn.now(),
    updated_at: knex.fn.now(),
  }));

  // Insert users with validation to avoid duplicates
  return Promise.all(
    users.map((user) => {
      return knex('users')
        .select('*')
        .where('name', user.name)
        .first()
        .then((existing) => {
          if (!existing) {
            return knex('users').insert(user);
          }
        });
    })
  );
};
