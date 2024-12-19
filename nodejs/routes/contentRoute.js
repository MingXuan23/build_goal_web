const express = require('express');
const router = express.Router();

const { getContents, saveContentEnrollment,  getContentEnrollment,getClickedContent} = require('../controllers/contentController');
const { fetchVectorContent} = require('../controllers/vectorController');

const { authenticateToken, authenticateApplication } = require('../middleware/authMiddleware');

// router.post('/register', authenticateApplication ,register);
// router.post('/login',  login);
// router.post('/verify/:email', authenticateApplication, verifyCode);
// router.post('/resend/:email', authenticateApplication ,resendVerificationCode); 
// router.post('/forget-password',authenticateApplication, forgetPassword); 
// router.get('/perform-forget-password', performForgetPassword); 

// router.post('/change-password',authenticateApplication, authenticateToken,changePassword);
// router.post('/validate-session',authenticateApplication, validateSession);

router.post('/', authenticateApplication,authenticateToken, fetchVectorContent ,getContents);
router.post('/save-content-attendance', authenticateApplication,authenticateToken ,saveContentEnrollment);
router.get('/get-attendance-history', authenticateApplication,authenticateToken ,getContentEnrollment);

router.get('/get-clicked-content', authenticateApplication,authenticateToken ,getClickedContent);


// router.post('/user_collection/save/:id', authenticateApplication, addPointUserCollection);
// router.post('/content_collection/save/:id', authenticateApplication, addPointContentCollection);




module.exports = router;
