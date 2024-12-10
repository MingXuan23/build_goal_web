const express = require('express');
const router = express.Router();
const { getContentCollection ,addPointContentCollection, addPointUserCollection,calVectorByLabel,saveUserVectorTest} = require('../controllers/vectorController');
const { authenticateToken, authenticateApplication } = require('../middleware/authMiddleware');

// router.post('/register', authenticateApplication ,register);
// router.post('/login',  login);
// router.post('/verify/:email', authenticateApplication, verifyCode);
// router.post('/resend/:email', authenticateApplication ,resendVerificationCode); 
// router.post('/forget-password',authenticateApplication, forgetPassword); 
// router.get('/perform-forget-password', performForgetPassword); 

// router.post('/change-password',authenticateApplication, authenticateToken,changePassword);
// router.post('/validate-session',authenticateApplication, validateSession);

router.get('/', authenticateApplication, getContentCollection);
router.get('/getVectorValue', calVectorByLabel);

router.post('/user_collection/save/:id', authenticateApplication, addPointUserCollection);
router.post('/content_collection/save/:id', authenticateApplication, addPointContentCollection);
router.post('/submit-vector-test', authenticateApplication,authenticateToken, saveUserVectorTest);

module.exports = router;
