var express = require('express');

var router = express.Router();

// const knexConfig = require('../knexfile');
// const knex = require('knex')(knexConfig[process.env.NODE_ENV])
/* GET home page. */

const { intialise } = require('../controllers/initlialiseController.js');
router.get('/', async function  (req, res, next) {
  
 
  res.status(200).json({ip:req.ip, ip2: req.headers['x-forwarded-for'] , ip3: req.connection.remoteAddress});
  //res.json("Hello dzsdcasd" + new Date());
});

router.get('/init', intialise);

module.exports = router;
