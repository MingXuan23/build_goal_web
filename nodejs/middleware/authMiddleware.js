const jwt = require('jsonwebtoken');

const authenticateToken = (req, res, next) => {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];
  if (token == null) return res.status(401).json({success : false, message: "Unauthorized access"});

  jwt.verify(token, process.env.JWT_SECRET, (err, user) => {
    if (err) return res.status(401).json({success : false, message: "Forbiden access"});
    req.user = user;
    // console.log(user);
    next();
  });
};

module.exports = { authenticateToken };
