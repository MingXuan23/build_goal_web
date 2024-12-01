require("dotenv").config();

const axios = require('axios');
const { Transform } = require('stream');

const HOST_URL = process.env.GPT_HOST;// Replace with your actual host URL
const model =process.env.GPT_MODEL;
const node_env = process.env.NODE_ENV;

const fastResponse = async (req, res, next) => {
    const { prompt, estimate_word } = req.body;

    if (!prompt) {
      console.error('Prompt is missing');
      return res.status(400).json({ error: 'Prompt is required' });
    }
  
    const estimateWords = estimate_word === undefined || estimate_word === null ? 10 : estimate_word;
  
    let final_prompt = '';
    if (estimateWords == -1) {
      final_prompt = `${prompt}. Response as short as possible.`;
    } else if (estimateWords == -2) {
      final_prompt = `${prompt}. Try to no reply too long if not related to financial domain.`;
    } else {
      final_prompt = `${prompt}. Response in ${estimateWords} words.`;
    }
  
    try {
      const apiResponse = await axios.post(`${HOST_URL}/api/chat`, {
        model: model, // Replace with your actual model name
        messages: [{ role: 'user', content: final_prompt }],
        options: {
          temperature: 0.5,
          
        },
      }, {
        headers: { 'Content-Type': 'application/json' },
        responseType: 'stream', // Important for streaming responses
      });
  
      if (apiResponse.status !== 200) {
        console.error(`API error: ${apiResponse.status}`);
        return res.status(apiResponse.status).json({ error: 'API error' });
      }
  
      // Set up response headers for streaming
      res.setHeader('Content-Type', 'text/event-stream');
      res.setHeader('Cache-Control', 'no-cache');
      res.setHeader('Connection', 'keep-alive');
  
      // Transform and forward the API response
      const transformStream = new Transform({
        transform(chunk, encoding, callback) {
          const data = chunk.toString().trim();
          if (data) {
            try {
              const jsonData = JSON.parse(data);
              const content = jsonData?.message?.content;
              console.log(content);
              if (content) {
                // Send content immediately to the client
                res.write(`${content}`);
              }
            } catch (e) {
              console.error('Error parsing chunk:', e, data);
            }
          }
          callback();
        },
      });
  
      apiResponse.data.pipe(transformStream);
  
      apiResponse.data.on('end', () => {
        console.log('Streaming completed');
        res.end();
      });
  
    } catch (error) {
      console.error('Error in /fast-response:', error.message);
      res.status(500).json({ error: 'Internal Server Error' });
    }
  
}


const slowResponse =async (req, res) => {
    let { prompt, estimate_word } = req.body;
  
    if (!prompt) {
      return res.status(400).json({ error: 'Prompt is required' });
    }
  
    estimate_word = estimate_word ?? 10;
  
    const final_prompt = `${prompt}. Response in ${estimate_word} words with simple language.`;
  
    try {
      const apiResponse = await axios.post(`${HOST_URL}/api/chat`, {
        model: model,
        messages: [{ role: 'user', content: final_prompt }],
        options: {
          temperature: 0.5,
          num_predict: 32,
        },
        stream:false
      });
      //res.status(500).json({ error: apiResponse.data });
      const content = apiResponse.data?.message?.content;
  
      if (!content) {
        return res.status(500).json({ error: 'Failed to retrieve content from API response' });
      }
  
      res.status(200).json({ content });
    } catch (error) {
      console.error('Error in /slow-response:', error.message);
      res.status(500).json({ error: 'Internal Server Error' });
    }
  };

  const loadModel =async (req, res) => {
    try {
      const apiResponse = await axios.post(`${HOST_URL}/api/generate`, {
        model: model,
        keep_alive: "30m"
      });

      const statusCode = apiResponse.status;

      res.status(statusCode).json({
        message: `The request is ${statusCode}`,
      });
    
    } catch (error) {
      console.error('Error in load Model:', error.message);
      res.status(500).json({ error: error });
    }
  };

  const pullModel =async (req, res) => {
    try {
        
        if(node_env == 'production'){
            return res.status(404).json('Not Found');
        }

      const apiResponse = await axios.post(`${HOST_URL}/api/pull`, {
        model: model,
        stream:false
      });

      const statusCode = apiResponse.status;

      res.status(statusCode).json({
        message: `${apiResponse.toString()}`,
      });
    
    } catch (error) {
      console.error('Error in load Model:', error.message);
      res.status(500).json({ error: error });
    }
  };


  module.exports = { fastResponse, slowResponse,loadModel,pullModel };