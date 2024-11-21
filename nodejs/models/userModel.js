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



const getUserByEmail = async (email) => {
  const [rows] = await promisePool.query(
    "SELECT verification_code,name,password,id,role,email_status,status,email FROM users WHERE email = ?",
    [email]
  );
  return rows[0];
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
  await promisePool.query('UPDATE users SET active = true, email_status = "VERIFY", status = "ACTIVE" WHERE email = ?', [email]);
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

module.exports = { getUserByEmail, createUser, updateUserStatus, updateVerificationCode , updatePassword};


