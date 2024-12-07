

require("dotenv").config();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const getUserByEmail = async (email) => {
  const user = await knex("users")
    .select(
      "verification_code",
      "name",
      "password",
      "id",
      "role",
      "email_status",
      "status",
      "email",
      "created_at",
      "active"
    )
    .where({ email })
    .first();
  return user;
};

const getUserByRememberToken = async (token) => {
  const user = await knex("user_token as ut")
    .join("users as u", "ut.user_id", "u.id")
    .where({ "ut.remember_token": token, "u.status": "ACTIVE" })
    .select(
      "u.id",
      "u.name",
      "u.telno",
      "u.address",
      "u.state",
      "u.email",
      "u.status",
      "u.password"
    )
    .first();
  return user;
};

const createUser = async (user) => {
  const {
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

  const [id] = await knex("users").insert({
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
  });
  return { id };
};

const updateUseProfile = async (user) => {
  const {name, telno, state, address,id} = user;
    //const validatedData = profileSchema.parse(userInfo);

    // Update user in the database
    const result = await knex("users")
      .where({ id :id})
      .update({
        name: name,
        telno: telno,
        state: state,
        address: address,
      });

    return result > 0; // Returns true if at least one row was updated
};

const updateUserStatus = async (email) => {
  await knex("users")
    .where({ email })
    .update({
      active: true,
      email_status: "VERIFY",
      status: "ACTIVE",
    });
};

const updateVerificationCode = async (email, newVerificationCode) => {
  const result = await knex("users")
    .where({ email })
    .update({ verification_code: newVerificationCode });
  return result;
};

const updatePassword = async (email, newPassword) => {
  const result = await knex("users")
    .where({ email })
    .update({ password: newPassword });
  return result;
};

const getStaticToken = (id, verify_id) => {
  const formatTwoDigits = (value) => value.toString().padStart(2, "0");

  const date = new Date(verify_id.toString());
  const M = formatTwoDigits(date.getMonth() + 1);
  const d = formatTwoDigits(date.getDate());
  const y = date.getFullYear().toString();
  const h = formatTwoDigits(date.getHours());
  const m = formatTwoDigits(date.getMinutes());
  const s = formatTwoDigits(date.getSeconds());
  const y1 = y.slice(0, 2);
  const y2 = y.slice(2);

  let token = [
    M,
    y1,
    h,
    id.toString(),
    s,
    m,
    d,
    y2,
  ].join("");

  token =
    token.substring(0, id % token.length).split("").reverse().join("") +
    token.substring(id % token.length).split("").reverse().join("");

  return token;
};

module.exports = {
  getUserByEmail,
  createUser,
  updateUserStatus,
  updateVerificationCode,
  updatePassword,
  getStaticToken,
  getUserByRememberToken,
  updateUseProfile
};
