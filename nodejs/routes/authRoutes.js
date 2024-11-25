const express = require('express');
const router = express.Router();
const { authenticateToken, authenticateApplication } = require('../middleware/authMiddleware');
const { register, login, verifyCode, resendVerificationCode,forgetPassword,changePassword ,validateSession, performForgetPassword } = require('../controllers/authController');

router.post('/register', authenticateApplication ,register);
router.post('/login',  login);
router.post('/verify/:email', authenticateApplication, verifyCode);
router.post('/resend/:email', authenticateApplication ,resendVerificationCode); 
router.post('/forget-password',authenticateApplication, forgetPassword); 
router.get('/perform-forget-password', performForgetPassword); 

router.post('/change-password',authenticateApplication, authenticateToken,changePassword);
router.post('/validate-session',authenticateApplication, validateSession);



module.exports = router;
