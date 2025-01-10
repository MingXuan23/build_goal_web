const express = require('express');
const router = express.Router();
const { authenticateToken, authenticateApplication } = require('../middleware/authMiddleware');
const { register, login, verifyCode, resendVerificationCode, forgetPassword, changePassword, validateSession, performForgetPassword, getStates, updateProfile, getProfile, updateUserPrivacy, addNewLeaf, getLeafStatus } = require('../controllers/authController');

router.post('/register', authenticateApplication, register);
router.post('/login', authenticateApplication, login);
router.post('/verify/:email', authenticateApplication, verifyCode);
router.post('/resend/:email', authenticateApplication, resendVerificationCode);
router.post('/forget-password', authenticateApplication, forgetPassword);
router.get('/perform-forget-password', performForgetPassword);
router.get('/get-states', authenticateApplication, getStates);


router.post('/change-password', authenticateApplication, authenticateToken, changePassword);
router.post('/validate-session', authenticateApplication, validateSession);
router.post('/update-profile', authenticateApplication, authenticateToken, updateProfile);

router.post('/get-profile', authenticateApplication, authenticateToken, getProfile);
router.post('/update-privacy', authenticateApplication, authenticateToken, updateUserPrivacy);

router.post('/add-new-leaf', authenticateApplication, authenticateToken, addNewLeaf);
router.get('/get-leaf-status', authenticateApplication, authenticateToken, getLeafStatus);








module.exports = router;
