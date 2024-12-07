var express = require('express');
const bcrypt = require("bcrypt");
var router = express.Router();

// const knexConfig = require('../knexfile');
// const knex = require('knex')(knexConfig[process.env.NODE_ENV])
/* GET home page. */
router.get('/', async function  (req, res, next) {
  
  var password = 'abc123'
  const hashedPassword = await bcrypt.hash(password, 10);
  const isMatch = await bcrypt.compare('abc123', hashedPassword);
  const isMatch2 = await bcrypt.compare('abc123', '$2b$12$RuEte7PqDgQutKywpJ4JC.6VyLtlVbQlZfu5wN33PlcsvcIDFVhnO');

  res.status(200).json({password:hashedPassword, result:isMatch, result2: isMatch2});
  //res.json("Hello dzsdcasd" + new Date());
});

module.exports = router;
