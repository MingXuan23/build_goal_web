const jwt = require('jsonwebtoken');

const knexConfig = require('../knexfile');
const knex = require('knex')(knexConfig[process.env.NODE_ENV])

const authenticateToken = (req, res, next) => {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];
  if (token == null) return res.status(401).json({success : false, message: "Unauthorized access, token not provided"});

  jwt.verify(token, process.env.JWT_SECRET, (err, user) => {
    if (err) return res.status(401).json({success : false, message: "Forbiden access, token is invalid"});
    req.user = user;
    console.log(user);
    next();
  });
};

const authenticateApplication = async (req, res, next) => {
  try {
    const applicationId = req.headers['application-id'];
   
    // Check if the application ID is provided
    if (!applicationId) {
      return res.status(503).json({
        success: false,
        message: 'Service Not Available',
      });
    }

    // Query the database for the application
    const app = await knex('application')
      .select('*')
      .where({ name: applicationId })
      .first();

    // Check if the application exists
    if (!app) {
      return res.status(503).json({
        success: false,
        message: 'Service Not Available',
      });
    }

    next(); // Proceed to the next middleware or route handler
  } catch (error) {
   
    return res.status(500).json({
      success: false,
      message: 'Internal Server Error',
      error:error
    });
  }
};


module.exports = { authenticateToken ,authenticateApplication};
