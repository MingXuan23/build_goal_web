const jwt = require('jsonwebtoken');

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

module.exports = { authenticateToken };
