var express = require('express');
var router = express.Router();

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])
/* GET home page. */
router.get('/', function(req, res, next) {
  res.json("Hello dzsdcasd" + new Date());
});

module.exports = router;
