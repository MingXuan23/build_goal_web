var express = require('express');
var router = express.Router();


const { authenticateToken, authenticateApplication } = require('../middleware/authMiddleware');
const { fastResponse, slowResponse,loadModel,pullModel,getFinancialAdvice } = require('../controllers/gptController');


// Streaming route
router.post('/fast-response', authenticateApplication,authenticateToken, fastResponse);

router.post('/slow-response',  authenticateApplication,authenticateToken, slowResponse);

router.post('/load',authenticateApplication, loadModel);
router.post('/pull', pullModel)

router.get('/get-financial-advice', authenticateApplication,authenticateToken,getFinancialAdvice)


module.exports = router;
