const express = require('express');
const router = express.Router();
const { authenticateToken } = require('../middleware/authMiddleware');
const { register, login, verifyCode, resendVerificationCode,forgetPassword,changePassword } = require('../controllers/authController');

router.post('/register', register);
router.post('/login', login);
router.post('/verify/:email', verifyCode);
router.post('/resend/:email', resendVerificationCode); 
router.post('/forget-password', forgetPassword); 
router.post('/change-password',authenticateToken,changePassword)


module.exports = router;
