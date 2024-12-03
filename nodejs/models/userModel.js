const mysql = require("mysql2");
require("dotenv").config();
const pool = mysql.createPool({
  user: process.env.LOCAL_DB_USER,
  password: process.env.LOCAL_DB_PASSWORD,
  database: process.env.LOCAL_DB_NAME,
  host: 'build_goal_web-mysql-1',
  port: 3306,//for inside docker mysql port
});
const promisePool = pool.promise();

pool.getConnection((err, connection) => {
  if (err) {
    console.error("Database connection failed:", err);
  } else {
    console.log("Database connected successfully!");
    connection.release();
  }
});

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV]);


const getUserByEmail = async (email) => {
  const [rows] = await promisePool.query(
    "SELECT verification_code,name,password,id,role,email_status,status,email,created_at, active FROM users WHERE email = ?",
    [email]
  );
  return rows[0];
};

const getUserByRememberToken = async (token) => {

  

  const user  = await knex("user_token as ut")
  .join("users as u", "ut.user_id", "u.id") // Use aliases for table names
  .where({ "ut.remember_token": token ,"u.status":"ACTIVE"}) // Use the alias in the condition

  .select("u.id","u.name", "u.telno", "u.address", "u.state", "u.email", "u.status","u.password") // Select all fields from both tables using aliases
  .first();

 



  return user;
};

const createUser = async (user) => {
  const {
    // id,
    name,
    password,
    telno,
    email,
    role,
    state,
    address,
    verification_code,
    status,
    email_status,
  } = user;
  const [result] = await promisePool.query(
    "INSERT INTO users ( name, password, telno, email ,role, state, address,verification_code, status, email_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)",
    [name,password,telno,email,role,state, address,verification_code,status,email_status]
  );
  return result;
};

const updateUserStatus = async (email) => {
  console.log(email)
  await promisePool.query('UPDATE users SET active = true, email_status = "VERIFY", status = "Active" WHERE email = ?', [email]);
};

const updateVerificationCode = async (email, newVerificationCode) => {

  const [result] = await promisePool.query('UPDATE users SET verification_code = ? WHERE email = ?', [newVerificationCode, email]);
  return result;
};


const updatePassword = async (email, newPassword) => {
  const [result] = await promisePool.query(
    "UPDATE users SET password = ? WHERE email = ?",
    [newPassword, email]
  );
  return result;
};

const getStaticToken = (id, verify_id) =>{
    const formatTwoDigits = (value) => value.toString().padStart(2, "0");
  
    // Convert createdAt string to a Date object
    const date = new Date(verify_id.toString()); // Ensure ISO format
  
    // Extract date components
    const M = formatTwoDigits(date.getMonth() + 1); // Months are zero-based
    const d = formatTwoDigits(date.getDate());
    const y = date.getFullYear().toString();
    const h = formatTwoDigits(date.getHours());
    const m = formatTwoDigits(date.getMinutes());
    const s = formatTwoDigits(date.getSeconds());
  
    // Split year into first two and last two characters
    const y1 = y.slice(0, 2);
    const y2 = y.slice(2);
  
    // Construct and return the token
    let token =  [
      M,            
      y1,        
      h,             
      id.toString(),
      s,           
      m,          
      d,              
      y2         
    ].join(""); // Combine all components
  
   token =  token.substring(0, id % token.length).split("").reverse().join("") + token.substring(id % token.length).split("").reverse().join("");
   return token;
   
}

module.exports = { getUserByEmail, createUser, updateUserStatus, updateVerificationCode , updatePassword,getStaticToken, getUserByRememberToken};


